<template>

    <div>
        <Toast position="top-right"/>

        <div class="row justify-content-center">
            <div class="col-md-5">

                <Card >
                    <template #header>
                        <h3 class="text-center pt-4">
                            Login Form Powered By PrimeVue
                        </h3>

                    </template>
                    <template #content>
                        <div class="p-fluid">
                            <form @submit.prevent="submit">
                                <div class="p-field">
                                    <label for="email">Email Address</label>
                                    <InputText id="email" type="email" v-model="form.email" required/>
                                </div>
                                <div class="p-field">
                                    <label for="pass">Password</label>
                                    <InputText id="pass" type="password" v-model="form.password" required/>
                                </div>

                                <Button type="submit" label="Log In" class="mt-5"/>

                            </form>

                        </div>
                    </template>
                </Card>
            </div>

        </div>

    </div>

</template>

<script>
    import InputText from 'primevue/inputtext'
    import Card from 'primevue/card';
    import Button from "primevue/components/button/Button";
    import Toast from "primevue/components/toast/Toast";

    export default {
        name: "LoginComponent",
        data: () => ({
            errors: [],
            form: {
                email: null,
                password: null
            }
        }),
        methods: {
            submit() {
                this.$http.post('/api/auth/login', this.form)
                    .then(response => {
                        const data = response.data.data
                        this.$toast.add({
                            severity: 'success',
                            summary: `Successfully login with JWT: ${data.access_token.slice(0, 20)}...`,
                            detail: 'Login Request',
                            life: 3000
                        });
                    })
                    .catch(error => {
                        error = error.response.data;

                        let details = '';

                        if (error.details) {
                            for (let err in error.details) {
                                details += error.details[err][0] + "\r\n"
                            }
                        }

                        this.$toast.add({
                            severity: 'error',
                            summary: error.message,
                            detail: details,
                            life: 3000
                        });
                    });
            }
        },
        components: {
            Toast,
            Button,
            InputText,
            Card
        }
    }
</script>

<style scoped>

</style>
