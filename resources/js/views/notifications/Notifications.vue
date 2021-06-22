<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>
        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{ translate('general.notifications.notifications') }}</h3>
            </b-card-header>
            <b-card-body>
                <b-row>
                    <b-col md="6">
                        <b-card>
                            <b-card-body>
                                <b-btn @click="showForm = !showForm" variant="primary">{{ translate('general.notifications.create') }} </b-btn>
                            </b-card-body>
                        </b-card>
                    </b-col>
                    <b-col md="6">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="showForm">
                            <b-form-group
                                id="input-group-1"
                                :label="translate('general.notifications.title')"
                                label-for="title"
                            >
                                <b-form-input
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group
                                id="input-group-1"
                                :label="translate('general.notifications.body')"
                                label-for="body"
                            >
                                <b-form-textarea
                                    id="body"
                                    v-model="form.body"
                                    type="text"
                                    rows="5"
                                    required
                                ></b-form-textarea>
                            </b-form-group>
                            <b-form-group :label="translate('general.notifications.via')">
                                <b-form-checkbox
                                    id="email"
                                    v-model="form.via"
                                    name="email"
                                    value="email"
                                    unchecked-value="null"
                                >
                                    {{ translate('general.notifications.via_email') }}
                                </b-form-checkbox>
                                <b-form-checkbox
                                    id="push"
                                    v-model="form.via"
                                    name="push"
                                    value="push"
                                    unchecked-value="null"
                                >
                                    {{ translate('general.notifications.via_push') }}
                                </b-form-checkbox>
                            </b-form-group>
                            <b-button type="submit" variant="primary">{{ translate('general.notifications.send') }}</b-button>

                        </b-form>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showForm: false,
            form: {
                title: null,
                body: null,
                via: 'email'
            },
            bItems: [
                {
                    text: trans.translate('general.dashboard'),
                    to: {name: 'dashboard'}
                },
                {
                    text: trans.translate('general.notifications.notifications'),
                    active: true
                }
            ],
        }
    },
    methods: {
        onSubmit(event) {
            event.preventDefault()
            let vm = this;
            axios.post(window.origin + '/admin/send-notifications',
                this.form).then(response => {
                if (response.data.success) {
                    console.log(response.success)
                    this.$swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: trans.translate('general.notifications.sent'),
                        showConfirmButton: false,
                        timer: 1500
                    })
                    vm.showForm = false;
                } else {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.data.message,
                    })
                }
            }, (error) => {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: trans.translate('general.error_message'),
                })
            });

        },
        onReset() {

        }
    }

}
</script>

<style scoped>

</style>
