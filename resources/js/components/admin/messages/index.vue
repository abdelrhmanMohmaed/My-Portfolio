<script setup>
import axios from "axios";
import { onMounted, ref, } from "vue";
import Base from '../layouts/base.vue';

let messages = ref([]);
onMounted(() => {
    getMessages();
});

const getMessages = async () => {
    let response = await axios.get('/api/messages');
    messages.value = response.data.messages;
}
const toggleStatus = (messageId) => {
    axios.get('/api/messages/toggle/' + messageId);
    getMessages();
    toast.fire({
        icon: 'success',
        title: 'Status Update successfully',
    });
}

const deleteMessage = (messageId) => {
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
            axios.get('/api/delete/message/' + messageId.id).then(() => {
                Swal.fire(
                    'Delete',
                    'Message delete successfully',
                    'success'
                );
                getMessages();
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

            <!--==================== MESSAGES ====================-->
            <section class="messages section" id="messages">
                <div class="messages_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Messages </h1>
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
                                <input class="table_search--input" type="text" placeholder="Search Message">
                            </div>
                        </div>

                        <div class="message_table-heading">
                            <p>Name</p>
                            <p>Email</p>
                            <p>Subject</p>
                            <p>Description</p>
                            <p>Status</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="message_table-items" v-for="item in messages" :key="item.id">
                            <p>{{ item.name }}</p>
                            <p>{{ item.email }}</p>
                            <p>{{ item.subject }}</p>
                            <p>{{ item.description }}</p>
                            <p @click="toggleStatus(item.id)">
                                <span class="badge_read" v-if="item.status == 0">
                                    Read
                                </span>
                                <span class="badge_unread btn-danger" v-else>
                                    Unread
                                </span>
                            </p>
                            <div>
                                <button class="btn-icon danger" @click="deleteMessage(item)">
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
