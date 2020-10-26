<template>
    <div>
        <form :action="route" method="post" enctype="multipart/form-data" @submit="submit">
            <input type="hidden" name="_token" :value="csrf">
            <div class="form-group">
                <input type="file" :name="name" required>
                <span class="invalid-feedback d-block" role="alert" v-if="errMsg">
                    <strong>{{ errMsg }}</strong>
                </span>
            </div>
            <div>
                <span class="font-bold">Notes: </span>
                <ul>
                    <li>- Max file size can be 15mb</li>
                    <li>- Allowed extension are jpeg,jpg,png</li>
                    <!-- <li>- Upload square image which same height and same width. for example 500x500</li> -->
                    <li>- Minimum image dimesion is 250x250</li>
                    <li>- New uploaded profile photo will be visible after admin verification</li>
                </ul>
            </div>
            <div class="text-right">
                <button class="btn btn-primary"
                    :disabled="submitting"
                >
                    Submit <span :class="{'d-none': !submitting}"><i class="fas fa-spinner fa-spin"></i></span>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        csrf: {required:true},
        route: {required: true},
        'err-msg': {type: String},
        name: {type: String, default: 'image'}
    },
    data(){
        return {
            submitting: false,
        };
    },
    methods: {
        submit(){
            this.submitting = true;
        }
    }
}
</script>

<style>

</style>