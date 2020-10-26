<template>
    <div>
        <carousel :nav="false" :margin="15"
            :autoplay="true"
            :autoplayTimeout="5000"
            :items="3"
            :responsive="{0:{items:2,nav:false},600:{items:3,nav:false}}"
        >
            <div class="carousel-image-item"  v-for="(image,imageindex) in images" 
                :key="'image-thumbnail-' + imageindex"
            >
                <img :src="image" @click="index = imageindex">
            </div>
            
        </carousel>
        <gallery :images="images" :index="index" @close="index = null"></gallery>
    </div>
</template>

<script>
import carousel from 'vue-owl-carousel'
import VueGallery from 'vue-gallery'

export default {
    components: {
        carousel,
        'gallery': VueGallery
    },
    data() {
        return {
            index: null,
        }
    },
    computed:{
        /**
         * 
         */
        images(){
            let data = [];
            for(var n = 0; n < 10; n++){
                var rand = 200 + (n * 50);
                var hrand = 200 + (n * 100);
                data.push('https://placeimg.com/'+rand+'/'+hrand+'/any?' + n);
            }
            return data;
        },
    },
    methods: {
        
    }
}

</script>

<style scoped>
.carousel-image-item{
    position: relative;
    height: 150px;
}

.carousel-image-item img{
    position: absolute;
    object-fit: cover;
    width: 100%;
    height: 100%;
}
</style>
