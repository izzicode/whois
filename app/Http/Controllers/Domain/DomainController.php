<?php

namespace App\Http\Controllers\Domain;

use App\Dto\DomainDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\DomainStringRequest;
use App\Http\Resources\DomainResource;
use Iodev\Whois\Factory;
use Iodev\Whois\Exceptions\ConnectionException;
use Iodev\Whois\Exceptions\ServerMismatchException;
use Iodev\Whois\Exceptions\WhoisException;

class DomainController extends Controller
{

    public function __invoke(DomainStringRequest $request)
    {
        try {
            $whois = Factory::get()->createWhois();
            $domainsInfo = [];

            foreach ($request->getDomains() as $domain) {
                if ($whois->loadDomainInfo($domain) === null) {
                    $domainsInfo[] = new DomainDto(
                        domain: $domain,
                        host: $domain,
                        text: 'Domain is available',
                    );
                    continue;
                }

                $data = array_merge(
                    $whois->loadDomainInfo($domain)->getResponse()->getData(),
                    ['expired_at' => $whois->loadDomainInfo($domain)->expirationDate],
                );

                $domainsInfo[] = DomainDto::fromArray($data);
            }

            return DomainResource::collection($domainsInfo);
        } catch (ConnectionException $e) {
            return "Disconnect or connection timeout";
        } catch (ServerMismatchException $e) {
            return "TLD server (.com for google.com) not found in current server hosts";
        } catch (WhoisException $e) {
            return "Whois server responded with error '{$e->getMessage()}'";
        }


    }

}
