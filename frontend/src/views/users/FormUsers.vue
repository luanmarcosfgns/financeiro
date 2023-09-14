<template>
       <input-form class-list="col-12"  type="string" label="Name " value="" name="name"/>
<input-form class-list="col-12"  type="string" label="Email " value="" name="email"/>
<input-form class-list="col-12"  type="timestamp" label="Email VerifIEd At " value="" name="email_verified_at"/>
<input-form class-list="col-12"  type="string" label="Password " value="" name="password"/>

</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormUsers",
    components: {InputForm},
    data() {
        return {users: null}
    },
    methods:{
         async getUsers(){
            let request =  new RequestHelper();
            this.users = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/users/list',{});
             this.users =  await this.users.data;

        },


    },
    created() {
        this.getUsers();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>