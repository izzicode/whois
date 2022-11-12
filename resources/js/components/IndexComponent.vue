<template>
    <div class="container">
        <form class="mb-3">
            <div class="mb-3">
                <label for="domain_input" class="form-label">Введите домен</label>
                <textarea cl placeholder="fb.com; vk.com" type="text" v-model="domain_input" class="form-control w-50" id="domain_input"></textarea>
            </div>
                    <div class="alert alert-danger" v-if="errors">
                        <ul v-for="error in errors">
                            <li>{{ error[0] }}</li>
                        </ul>
                    </div>

            <button @click.prevent="checkDomain" type="submit" class="btn btn-primary">Проверить</button>

        </form>
        <table class="table table-responsive">
            <thead>
            <tr>
                <th scope="col">DOMAIN</th>
                <th>HOST</th>
                <th>INFO</th>
                <th>EXPIRED AT</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="domain in domains">
                    <td>{{domain.domain}}</td>
                    <td>{{domain.host}}</td>
                    <td><pre>{{domain.text}}</pre></td>
                    <td>{{domain.expired_at}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "IndexComponent",

    data(){
        return {
            domain_input: null,
            domain_title: null,
            domains: [],
            errors:null
        }
    },

    methods:{
        checkDomain(){
            axios.post(`/api/domain`, {domain: this.domain_input})
                .then(res => {
                    this.domains = res.data.data;
                    this.ex_date = res.data.data.expired_at;
                    this.domain_title = this.domain_input;
                    this.errors = null;
                })
                .catch(error => {
                    if (error.response.status == 422){
                        this.errors = error.response.data.errors || {};
                    }})

        },
    }
}
</script>

<style scoped>

</style>
