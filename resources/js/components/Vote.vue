<template>
    <div class="d-flex flex-column vote-controls">
        <a @click.prevent="voteUp" :title="title('up')" class="vote-up" :class="classes"
        >
            <i class="fa fa-caret-up fa-3x"></i>
        </a>

        <span class="vote-count">{{count}}</span>
        <a @click.prevent="voteDown" :title="title('down')" class="vote-down" :class="classes"
        >
            <i class="fa fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="name === 'question'" :question="model"></favorite>

        <accept v-else :answer="model"></accept>

    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import Accept from './Accept.vue';


    export default {
        components: {Accept, Favorite},
        props:['name', 'model'],

        computed:{
            classes(){
                return this.signedIn? '': 'off';
            },
            endPoint(){
                return `/${this.name}s/${this.id}/vote`;
            }
        },

        comments:{
            Favorite,
            Accept
        },

        data(){
            return {
                count:this.model.votes_count || 0,
                id:this.model.id
            }
        },

        methods:{
            title(voteType){
                let titles = {
                    up: `this ${this.name} is useful`,
                    down: `this ${this.name} is unuseful`
                }
                return titles[voteType];
            },
            voteUp(){
                this._vote(1);
            },
            voteDown(){
                this._vote(-1);
            },
            _vote(vote){

                if(!this.signedIn){
                    this.$toast.warning(`Please login to vote the ${this.name}`, 'Warning', {
                        timeout: 3000,
                        position: 'bottomLeft'
                    })

                    return;
                }

                axios.post(this.endPoint, {vote})
                    .then(res => {
                        console.log(res.data.votesCount)
                        this.$toast.success(res.data.message, "Success",{
                            timeout: 3000,
                            position: 'bottomLeft'
                        });
                        this.count = res.data.votesCount;
                    })
            }
        }


    }
</script>