<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Download Report</h4>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Image Name</th>
                                <th style="width: 35%;">Category</th>
                                <th>Total Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in tableData.data" :key="index">
                                <td>
                                    {{ item.name }}
                                </td>
                                <td>
                                    {{ item.category?.title }}
                                </td>
                                <td class="text-capitalize">
                                    {{ item.total_downloads }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <Bootstrap5Pagination
                        :data="tableData"
                        @pagination-change-page="getTableData"
                        align="right"
                        size="small"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import { useAuthStore } from '../../stores/auth';

const tableData = ref({});

onMounted(() => {
    getTableData();
});

const authStore = useAuthStore();

const getTableData = async(page = 1) => { // Get Users list from api
    try{
        const response = await axios.get(`/images?page=${page}&user_id=${authStore.user?.id}`);
       
        if(response) {
            if(response.data.success) {
                tableData.value = response.data.data;
            }
        }
    } catch (error) {
        console.error(error);
    }
};
</script>

<style scoped>

</style>