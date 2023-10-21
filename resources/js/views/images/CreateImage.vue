<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Upload Image</h4>
                
                <!-- Image Form Start -->
                <form method="post" @submit.prevent="handleSubmit()" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="image_name" class="form-label">Image Name:</label>
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="image_name"
                            maxlength="255"
                            v-model="form.name"
                            required
                        >
                        <ValidationError :errors="errors" :field="'name'"/>
                    </div>
                    <div class="mb-3">
                        <label for="image_file" class="form-label">Image:</label>
                        <input
                            type="file"
                            class="form-control"
                            name="file"
                            id="image_file"
                            @change="uploadFile"
                            required
                        >
                        <ValidationError :errors="errors" :field="'file'"/>
                    </div>

                    <div class="mb-3">
                        <label for="image_category_id" class="form-label">Category:</label>
                        <select
                            class="form-select"
                            name="category_id"
                            id="image_category_id"
                            v-model="form.category_id"
                            required
                        >
                            <option value="">-- SELECT --</option>
                            <option :value="item.id" v-for="(item, index) in categories" :key="index">
                                {{ item.title }}
                            </option>
                        </select>
                        <ValidationError :errors="errors" :field="'category_id'"/>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
                <!-- Image Form End -->

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import ValidationError from '../../components/layout/elements/ValidationError.vue';
const initialFormData = {
    name: '',
    file: null,
    category_id: '',
};

const form = reactive({...initialFormData});

const errors = ref({});
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
        if(error) {
            if(error.response?.status == 422) {
                errors.value = error.response.data.errors;
            }
        }
    }
};


const handleSubmit = async () => { // Submit image form
    try{
        errors.value = {};

        const response = await axios.post('/images/store', form);
       
        if(response) {
            if(response.data.success) {
                Object.assign(form, initialFormData);
                toastr.success(response.data.message);
            }
        }
    } catch (error) {
        console.log(error);
        if(error) {
            if(error.response?.status == 422) {
                errors.value = error.response.data.errors;
            }
        }
    }
};

const uploadFile = (event) => { // Handle File in form
  form.file = event.target.files[0];
};
</script>

<style scoped>

</style>