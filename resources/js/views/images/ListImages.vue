<template>
    <div>
        <div class="row">
            <div class="col-lg-3">
                <div class="filters border p-2">
                    <h4 class="border-bottom pb-2">Category</h4>
                  
                    <!-- Filters Start -->
                        <div class="form-check" v-for="(item, index) in categories" :key="index">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                :value="item.id"
                                name="filter_categories[]"
                                @change="getTableData()"
                                :id="'cat_'+item.id"
                                v-model="filters.categories"
                            >
                            <label class="form-check-label" :for="'cat_'+item.id">
                                {{ item.title }}
                            </label>
                        </div>
                    <!-- Filters End -->
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row" v-if="tableData.data?.length">
                    <div class="col-lg-4 col-md-6 mb-3" v-for="(item, index) in tableData.data" :key="index">
                        <div class="card">
                            <img :src="path(item)" :alt="item.name" class="card-img-top pop-image" height="180" @click="showModal(item)">

                            <div class="card-body">
                                <p>
                                    <strong>Contributor: </strong>{{ item.user?.name }}
                                </p>
                                <p>
                                    <strong>Image Name: </strong>{{ item.name }}
                                </p>
                                <p>
                                    <strong>Category: </strong> {{ item.category?.title }}
                                </p>
                                <p class="text-capitalize">
                                    <strong>Total Downloads: </strong> {{ item.total_downloads }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div v-else>
                    No Records found...
                </div>

                <Bootstrap5Pagination
                    :data="tableData"
                    @pagination-change-page="getTableData"
                    align="right"
                    size="small"
                />
            </div>
        </div>

        <Modal ref="imageModal" title="Download Image">
            <template #content>
                <div v-if="modalData">
                    <img :src="path(modalData)" :alt="modalData.name" class="w-100">
                    <hr>
                    <p>
                        <strong>Contributor: </strong>{{ modalData.user?.name }}
                    </p>
                    <p>
                        <strong>Image Name: </strong>{{ modalData.name }}
                    </p>
                    <p>
                        <strong>Category: </strong> {{ modalData.category?.title }}
                    </p>
                    <p class="text-capitalize">
                        <strong>Total Downloads: </strong> {{ modalData.total_downloads }}
                    </p>
                    <hr>
                    <div class="text-center">
                        <a class="btn btn-warning" :href="path(modalData)" download role="button" @click="imageDownloaded(modalData)">Download</a>
                    </div>
                </div>
            </template>
        </Modal>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Modal from '../../components/layout/elements/Modal.vue';
import { useRouter } from 'vue-router';

const router = useRouter();

// Grid Data
const tableData = ref({});
const filters = ref({
    categories: []
});

onMounted(() => {
    getTableData();
});

const path = (item) => {
    return  item ? '/storage/'+item.path : null;
};

const getTableData = async(page = 1) => { // Get Users list from api
    try{
        const params = new URLSearchParams(filters.value).toString();

        const response = await axios.get(`/images?page=${page}&${params}`);
       
        if(response) {
            if(response.data.success) {
                tableData.value = response.data.data;
            }
        }
    } catch (error) {
        console.error(error);
    }
};

// Category
const categories = ref({});

onMounted(() => {
    getCategories();
});

const getCategories = async() => { // Get Categories list from api
    try{
        const response = await axios.get('/categories/all');
       
        if(response) {
            if(response.data.success) {
                categories.value = response.data.data;
            }
        }
    } catch (error) {
        console.log(error);
    }
};

// Modal
const imageModal = ref(null);
const modalData = ref(null);

const showModal = (item) => {
    modalData.value = item;
    imageModal.value.show();
};

// Download Image
const imageDownloaded = async(item) => {
    try{
        const response = await axios.post(`/images/increase-download-count/${item.id}`);
        modalData.value.total_downloads++;

        if(response) {
            if(response.data.success) {
                toastr.success("Thank you for downloading.");
            }
        }

        getTableData();
    } catch (error) {
        console.log(error);
    }
};
</script>

<style scoped>
.pop-image{
    cursor: pointer;
}
</style>