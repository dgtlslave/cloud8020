<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5>Vehicle parks list</h5>
                            <a href="/park/create" class="btn btn-sm btn-success">New park</a>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class='d-flex justify-content-between mb-1' v-for="park in parks">
                                <span>{{ park.name }}</span>
                                <div>
                                    <a class="btn btn-sm btn-info" >View</a>
                                    <!-- <a class="btn btn-sm btn-warning" :href="'/park/edit/'+park.id">Edit</a> -->
                                    <a class="btn btn-sm btn-warning" :id="park.id" @click.prevent="edit_park(park.id)">Edit</a>
                                    <button class="btn btn-sm btn-danger">Remove</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import EventBus from '../app'

export default {
    props:['id'],
    data(){
        return {
            parks: [],

        }
    },
    methods: {
        getAllPark() {
            axios.get('/getAllPark').then((response)=>{
                this.parks = response.data
            })
        },
        edit_park(id){
            let url = 'https://atptest.site/park/'+id+'/edit'
                axios.get(url).then((response)=>{
                    window.location.href = url
                }).catch((errors)=>{
                    console.log(errors.response.data);
                })
        },
        viewPark(id) {
            axios.get('/viewPark', {'id': id}).then((response) => {
                // window.location.href =
            })
        }
        // del(){
        //     axios.post('/regionDeleteData', this.selected_delete).then((response)=>{
        //         if(response.data = '1'){
        //             swal('Deleted', 'Region unit deleted', 'success').then((response)=>{
        //                 window.location.href = "/options"
        //             })
        //         }
        //     })
        // }

    },
    mounted() {
        this.getAllPark()
    }
}
</script>

