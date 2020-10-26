<template>
    <div>
        <b-modal id="modal-rso" title="Would you like to register service?"
            :hide-footer="true" :hide-header="true"
            centered
        >
            <div class="d-flex justify-content-between">
                <span>Would you like to provide service? </span>
                <span @click="$bvModal.hide('modal-rso')"><i class="fas fa-times"></i></span>
            </div>
            <div>
                <a href="/provide-service" class="pr-2 link underline">Provide</a>
                <a href="#" class="link text-black underline"
                    @click="$bvModal.hide('modal-rso')"
                >Later</a>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {
    mounted()
    {
        setTimeout(() => {
            this.$bvModal.show('modal-rso')
        }, 2000)
    }
}
</script>

<style>

</style>