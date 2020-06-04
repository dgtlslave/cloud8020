<template>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <!-- <label class="text-center" for="vehicle_number">Vehicle number</label> -->
                    <input type="text" class="form-control" :vn="vn">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <!-- <label class="text-center" for="driver_name">Driver name</label> -->
                    <input type="text" class="form-control" :dn="dn">
                </div>
            </div>
            <div class="col-md-1">
                <!-- <label for="driver_name"></label> -->
                <button class="btn btn-sm btn-danger">X</button>
            </div>
        </div>
    </div>
</template>

<script>

// import EventBus from '../app'

export default {
    // components: {
    // 'add-vehicle': AddVehicle
    // },
    props: ['vn', 'dn'],
    // components: {
    //         'add-vehicle': AddVehicle
    //     },
    data(){
        return {
            // adds: [
                vh: '',
                dn: '',
                // vehicle_number: '',
                // driver_name: ''
            // ]
        }
    },
    methods: {

    },
    mounted(){
        // setAll()
    }

}
</script>
