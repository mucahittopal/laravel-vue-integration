<template>
    <div>
        <b-pagination-nav :pages="pageLinks" align="center"></b-pagination-nav>
    </div>
</template>

<script>
export default {
    props: [
        'last-page', 'base-url', 'http-params'
    ],
    data(){
        return {
            page: null,
        };
    },
    computed: {
        pageLinks(){
            var links = [];
            for(var i = 1; i <= this.lastPage; i++){
                var link = this.baseUrl + '/?' + this.httpParams;
                if(i > 1)
                    link += this.httpParams ? '&page=' + i : 'page=' + i;
                links.push(link);
            }
            return links;
        }
    },
    mounted(){
        this.page = this.currentPage;
    },
    methods: {
        
    }
}
</script>

<style>

</style>