<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5>Add vehicle to list of :</h5>
                            <div>
                                <a v-if="role_perm.includes('create vehicle', 'create vehicle')" class="btn btn-sm btn-success" @click.prevent="create_view()">Add vehicle</a>
                                <a href="/park" class="btn btn-sm btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush" v-if="vehicles.length > 0">
                        <li class="list-group-item">
                            <div class='d-flex justify-content-between mb-1' v-for="vehicle in vehicles">
                                <span>{{ vehicle.vehicles_number }}</span>
                                <span>{{ vehicle.driver }}</span>
                                <div>
                                    <a v-if="role_perm.includes('edit vehicle', 'edit vehicle')" class="btn btn-sm btn-warning" @click.prevent="edit_vehicle(vehicle.id)">Edit</a>
                                    <a v-if="role_perm.includes('delete vehicle')" class="btn btn-sm btn-danger" @click.prevent="delete_vehicle(vehicle.id)">Remove</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="list-group list-group-flush" v-else>
                        <div class="card border-info text-info text-center m-1">
                            No existing vehicles, yet.
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
import axios from 'axios'

export default {
    data(){
        return {
            vehicles: '',
            park_id: 16,
            role_perm: ''
        }
    },
    methods: {
        get_auth_user(){
            axios.get('/get_auth_user').then((response)=>{
                this.role_perm = response.data
            })
        },
        edit_vehicle() {
            this.vehicles = this.$attrs.park
        },
        set_park_id() {
            if(this.$attrs.park.length > 0){
                this.park_id = this.$attrs.park[0].pivot.park_id
            }
        },
        create_view(){
            axios.get('/create_view/' + this.park_id).then((response) => {
                    window.location.href = "https://atptest.site/create_view/" + this.park_id
            }).catch((errors) => {
                console.log(errors)
            })
        },
        delete_vehicle(id){
            axios.post('/delete_vehicle', {'id': id}).then((response) =>{
                if(response.data.vehicles_number){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You try to delete:"+response.data.vehicles_number,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            window.location.href = 'https://atptest.site'+window.location.pathname
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
    },
    mounted() {
        this.edit_vehicle()
        this.set_park_id()
        this.get_auth_user()
    }
}
</script>
