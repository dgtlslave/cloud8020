<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Edit park: {{this.$attrs.park.name}}</span>
                            <div>
                                <a href="/park" class="btn btn-sm btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="v_p_name">Vehicle park name</label>
                                <input type="text" class="form-control" v-model="edit.name">
                            </div>
                            <div class="form-group">
                                <label for="v_p_address">Vehicle park address</label>
                                <input type="text" class="form-control" v-model="edit.address">
                            </div>
                            <div class="d-flex">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8 offset-2">
                                            <div class="card border-info text-info text-center">
                                                <!-- <div class="card-body card-sm text-info "> -->
                                                    Current time of work: {{ edit.schedule }}
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="v_p_address">Beginning of work</label>
                                                <select class="form-control" v-model="edit.start">
                                                    <option selected value="8:00">7:00</option>
                                                    <option value="8:30">7:30</option>
                                                    <option value="9:00">8:00</option>
                                                    <option value="8:30">8:30</option>
                                                    <option value="9:00">9:00</option>
                                                    <option value="9:30">9:30</option>
                                                    <option value="10:00">10:00</option>
                                                    <option value="10:30">10:30</option>
                                                    <option value="11:00">11:00</option>
                                                    <option value="11:30">11:30</option>
                                                    <option value="12:00">12:00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>End of work</label>
                                                <select class="form-control" v-model="edit.end">
                                                    <option selected value="17:00">17:00</option>
                                                    <option value="17:30">17:30</option>
                                                    <option value="18:00">18:00</option>
                                                    <option value="18:30">18:30</option>
                                                    <option value="19:00">19:00</option>
                                                    <option value="19:30">19:30</option>
                                                    <option value="20:00">20:00</option>
                                                    <option value="20:30">20:30</option>
                                                    <option value="21:00">21:00</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" @click.prevent="save_edited_park()" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
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
            edit: {
                id: '',
                name: '',
                address: '',
                schedule: '',
                start: '',
                end: ''
            }
        }
    },
    methods: {
        getReceivedData() {
            this.edit.id = this.$attrs.park.id
            this.edit.name = this.$attrs.park.name
            this.edit.address = this.$attrs.park.address
            this.edit.schedule = this.$attrs.park.schedule
            this.edit.start = ''
            this.edit.end = ''
        },
        save_edited_park(){
            axios.post('/save_edited_park', this.edit).then((response) => {
                if(response.data == 1){
                    Swal.fire({
                        // position: 'top-end',
                        icon: 'success',
                        title: 'Changes has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        // window.location.href = 'https://atptest.site/park'
                    })
                } else if(response.data == 2) {
                    swal.fire('Warning', 'Nothing to change.', 'warning' )
                }
            }).catch((errors) => {
                console.log(errors.data)
            })
        }
    },
    mounted() {
        this.getReceivedData()
    }
}
</script>
