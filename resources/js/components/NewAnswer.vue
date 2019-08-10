<template>
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>Your answer</h2>
                    </div>
                    <hr>
                    <form @submit.prevent="create">
                        <div class="form-group">
                            <textarea name="body" rows="7" class="form-control" required v-model="body"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" :disable="isValid" class="btn btn-lg btn-outline-primary">Sumbit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['questionId'],

        methods:{
            create(){
                axios.post(`/questions/${this.questionId}/answers`,{
                    body: this.body
                })
                .catch(error=>{
                    this.$toast.error(error.response.data.message, "Error");
                })
                .then(({data})=>{
                    this.$toast.success(data.message, "Success");
                    this.body = '';
                    this.$emit('create', data.answer)
                })
            }
        },

        data(){
            return {
                body: ''
            }
        },

        computed:{
            isValid(){
                return ! this.signedIn || this.body.length < 10;
            }
        }
    }
</script>