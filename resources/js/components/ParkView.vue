<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5>Vehicle parks list</h5>
                            <div>
                                <a v-if="role_perm.includes('create vehicle', 'create vehicle')" href="/vehicle/create" class="btn btn-sm btn-success">Add vehicle</a>
                                <a v-if="role_perm.includes('create park')" href="/park/create" class="btn btn-sm btn-success">New park</a>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush" v-if="parks.length > 0">
                        <li class="list-group-item">
                            <div class='d-flex justify-content-between mb-1' v-for="park in parks">
                                <span>{{ park.name }}</span>
                                <div>
                                    <a class="btn btn-sm btn-info" @click.prevent="view_vehicle(park.id)">View</a>
                                    <a v-if="role_perm.includes('edit park')" class="btn btn-sm btn-warning" @click.prevent="edit_park(park.id)">Edit</a>
                                    <a v-if="role_perm.includes('delete park')" class="btn btn-sm btn-danger" @click.prevent="delete_park(park.id)">Remove</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="list-group list-group-flush" v-else>
                        <div class="card border-info text-info text-center m-1">
                            No existing parks, yet.
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import EventBus from '../app'
import Swal from 'sweetalert2'

export default {
    data(){
        return {
            parks: [],
            errors: {},
            role_perm: ''
        }
    },
    methods: {
        get_auth_user(){
            axios.get('/get_auth_user').then((response)=>{
                this.role_perm = response.data
            })
        },
        getAllPark() {
            axios.get('/getAllPark').then((response)=>{
                this.parks = response.data
            })
        },
        edit_park(id){
            axios.get('/edit_view/' + id).then((response) => {
                    window.location.href = "https://atptest.site/edit_view/" + id
            }).catch((errors) => {
                console.log(errors)
            })
        },
        delete_park(id){
            axios.post('/delete_park', {'id': id}).then((response) =>{
                if(response.data.name){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You try to delete:"+response.data.name,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            console.log(result)
                            if (result.isConfirmed) {
                                Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                            }
                    })
                }
            }).catch((errors) => {
                console.log(errors)
            })
        },
        view_vehicle(id) {
            axios.get('/view_vehicle/' + id).then((response) => {
                    window.location.href = "https://atptest.site/view_vehicle/" + id
            }).catch((errors) => {
                console.log(errors)
            })
        }
    },
    mounted() {
        this.getAllPark()
        this.get_auth_user()
    }
}
</script>

