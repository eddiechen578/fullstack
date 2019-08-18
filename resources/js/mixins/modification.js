export default {
    data(){
        return {
            editing: false
        }
    },

    methods:{
        edit(){
            this.setEditCache();

            this.editing = true;
        },

        cancel(){
            this.restoreCache();

            this.editing = false;
        },

        setEditCache(){},

        restoreCache(){},

        update(){
            axios.put(this.endpoint, this.payload())
                .then(({data})=>{
                    this.bodyHtml = data.body_html
                        this.$toast.success(data.message, "Success", {
                            timeout:3000
                        });
                    this.editing = false;
                })

        },

        payload(){},

        destroy(){
            this.$toast.question('Are you sure about that?', "confirm",{
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) => {

                       this.delete();

                       instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                       instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ]
            });
        },

        delete(){}
    }
}