<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Create new vehicles</span>
                            <div>
                                <a href="/park" class="btn btn-sm btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select name="" id="" class="form-control" v-model="selected_park">
                                                <option value="">Choose park</option>
                                                <option v-for="park in parks" :value='park.id'>{{ park.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 text-center">Vehicle number</div>
                                    <div class="col-md-6 text-center">Driver name</div>
                                    <div class="col-md-2 text-center">
                                        <button @click.prevent="addRow()" class="btn btn-sm btn-success">Add driver</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label class="text-center" for="vehicle_number">Vehicle number</label> -->
                                            <input type="text" class="form-control" v-model="vehicle_number">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <div class="form-group">
                                            <!-- <label class="text-center" for="driver_name">Driver name</label> -->
                                            <input type="text" class="form-control" v-model="driver_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-sm" v-show="form.vehicles">
                                        <tbody>
                                            <tr style="width:100%;" v-for="(vehicle, index) in form.vehicles">
                                                <td class="text-center" style="width:9%;">{{ index + 1 }}</td>
                                                <td class="text-center" style="width:20%;">{{ vehicle.number }}</td>
                                                <td class="text-left" style="width:34%;">{{ vehicle.driver }}</td>
                                                <td class="text-right" style="width:27%;">
                                                    <button class="btn btn-danger btn-sm" @click.prevent="removeRow(index)">Remove</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <button type="submit" @click.prevent="saveVehicle()" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import swal from 'sweetalert2'
import axios from 'axios'

export default {
    data(){
        return {
            parks: '',
            selected_park: '',
            vehicle_number: '',
            driver_name: '',
            form: {
               vehicles: []
            },
            errors: ''
        }
    },
    methods: {
        getAllPark(){
            axios.get('/getAllPark').then((response)=> {
                this.parks = response.data
            })
        },
        addRow() {
            if(this.selected_park.length != 0 && this.vehicle_number.length != 0 && this.driver_name.length != 0) {
                let number = this.vehicle_number
                number = number.trim().replace(/\s/g, "").toUpperCase()
                this.form.vehicles.push({'park': this.selected_park, 'number': number, 'driver': this.driver_name })
                this.vehicle_number = ''
                this.driver_name = ''
                number = ''
            } else {
                return alert('You need paste all line!')
            }
        },
        removeRow(index) {
            this.form.vehicles.splice(index, 1)
        },
        saveVehicle() {
            axios.post('/saveVehicle', this.form).then((response)=>{
                if(response.data == true){
                    swal.fire('Success', 'Vehicles successfuly saved', 'success').then((result) => {
                        window.location.href = 'https://atptest.site/park'
                    })
                } else {
                    swal.fire('Error','Something went wrong','error')
                }
            }).catch((errors)=>{
                // if(errors.response.data.errors.v_p_name) {
                //     swal.fire('Error', 'Please fill park name field and try again. Thanks.', 'error' )
                // } else if(errors.response.data.errors.v_p_address) {
                //     swal.fire('Error', 'Please fill park address field and try again. Thanks.', 'error' )
                // }
                console.log(errors.response.data.errors);

            })
        }


    },

    mounted() {
        this.getAllPark()
    },
}

</script>
