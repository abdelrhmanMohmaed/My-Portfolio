<script setup>
import axios from "axios";
import { onMounted, ref, } from "vue";
import { useRouter } from "vue-router";
import Base from '../layouts/base.vue';

let testimonials = ref([]);
let router = useRouter();
onMounted(() => {
    getTestimonials();
});

const getTestimonials = async () => {
    let response = await axios.get('/api/testimonials');
    testimonials.value = response.data.testimonials;
}

const ourImage = (img) => {
    let photo = '/img/upload/' + img;
    return photo;
}

const createTestimonial = () => {
    router.push('/admin/create/testimonial')
}
const editTestimonial = (item) => {
    router.push('/admin/edit/testimonial/' + item)
}

const deleteTestinonial = (testinonial) => {
    Swal.fire({
        title: 'Are you sure ?',
        text: "You can't go back",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085ds',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it',
    }).then((result) => {
        if (result.value) {
            axios.get('/api/delete/testimonials/' + testinonial.id).then(() => {
                Swal.fire(
                    'Delete',
                    'Testinonial delete successfully',
                    'success'
                );
                getTestimonials();
            })
        }
    });
}



</script>

<template>
    <Base />
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <!--==================== TESTIMONIALS ====================-->
            <section class="testimonials section" id="testimonials">
                <div class="testimonials_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Testimonials </h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn__open--modal" @click="createTestimonial">
                                New Testimonial
                            </div>
                        </div>
                    </div>

                    <div class="table">

                        <div class="table_filter">
                            <span class="table_filter-Btn ">
                                <i class="fas fa-ellipsis-h"></i>
                            </span>
                            <div>
                                <ul class="table_filter-list">
                                    <li>
                                        <p class="table_filter-link table_filter-link--active">
                                            All
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="table_search">
                            <div class="table_search-wrapper">
                                <select class="table_search-select" name="" id="">
                                    <option value="">Filter</option>
                                </select>
                            </div>
                            <div class="relative">
                                <i class="table_search-input--icon fas fa-search "></i>
                                <input class="table_search--input" type="text" placeholder="Search Testimonial">
                            </div>
                        </div>

                        <div class="testimonial_table-heading">
                            <p>Photo</p>
                            <p>name</p>
                            <p>Function</p>
                            <p>Testimony</p>
                            <p>Rating</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="testimonial_table-items" v-for="item in testimonials" :key="item.id">
                            <p>
                                <img :src="ourImage(item.photo)" alt="" class="testimonial_img-list">
                            </p>
                            <p>{{ item.name }}</p>
                            <p>{{ item.function }}</p>
                            <p>{{ item.testimony }}</p>
                            <p>{{ item.rating }}/5</p>
                            <div>
                                <button class="btn-icon success" @click="editTestimonial(item.id)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="deleteTestinonial(item)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </section>



        </div>
    </main>
</template>
