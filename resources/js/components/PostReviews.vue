<template>
    <div>
        <ul class="review-list mt-3">
            <li class="review-item" v-for="(review,index) in reviews" :key="'review-' + index">
                <div class="review-item-img">
                    <div class="img-wrapper">
                        <img :src="review.profile_photo">
                    </div>
                </div>
                <div>
                    <div>
                        <span class="font-bold">{{review.user_name}}</span>
                        <span class="px-2">
                            <span class="text-orange"><i class="fas fa-star"></i></span> {{review.rate}}
                        </span>
                    </div>
                    <span>{{review.text}}</span>
                    <div>
                        <span class="text-muted">Published {{review.created_at}}</span>
                    </div>
                </div>
            </li>
        </ul>
        <div class="text-center font-size-30px" :class="{'d-none': !fetching}">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
        <div class="text-center" v-if="has_next" @click="load_more">
            <a href="javascript:;" class="link text-black underline">
                <h5>Load More</h5>
            </a>
        </div>
    </div>
</template>

<script>


export default {
    props: {
        'post-id': {type: String},
        'review-count': {type: String},
    },
    data()
    {
        return {
            reviews: [],
            page: 1,
            fetching: false,
        };
    },
    computed: {
        has_next(){
            return (this.reviewCount - (this.page * 5)) > 0 ? true : false;
        }
    },
    mounted()
    {
        this.fetch_reviews();
    },
    methods: {
        /**
         * 
         */
        fetch_reviews(){
            this.fetching = true;
            axios.get('/post/' + this.postId + '/reviews?page=' + this.page)
                .then(resp => {
                    resp.data.forEach(item => this.reviews.push(item));
                    this.fetching = false;
                    console.log(resp.data)
                })  
                .catch(err => {
                    this.fetching = false;
                });  
        },

        /**
         * 
         */
        load_more()
        {
            this.page++;
            this.fetch_reviews();
        },
    }
}
</script>

<style scoped>

</style>