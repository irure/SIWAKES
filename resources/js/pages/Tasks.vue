<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <button type="button" class="btn btn-danger">タスク一覧</button>
                    <button type="button" class="btn btn-danger">グラフ</button>
                    <button type="button" class="btn btn-danger">担当者変更</button>
                </div>
                <div class="card" v-for="task in tasks">
                    <div class="card-header">
                        <input type="text" class="form-control" id="task" v-model="task.task" @blur="updateTask(task.id)">
                        <input type="howlong" class="form-control" id="howlong" v-model="task.howlong" @blur="updateHowlong(task.id)">
                        <select class="form-control" v-model="task.howtimes" @blur="updateHowtimes(task.id)">
                            <option v-for="time in times">
                                {{ time }}
                            </option>
                        </select>
                        <select class="form-control" v-model="task.charge" @blur="updateCharge(task.id)">
                            <option v-for="charge in charges">
                                {{ charge }}
                            </option>
                        </select>
                        <button type="button" class="btn btn-danger" @click="deleteTask(task.id)">Delete</button>
                    </div>
                </div>
                <div class="card">
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputtask" v-model="taskForm.task" @blur="addTask">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                active_task: null,
                tasks:[],
                taskForm:{
                    task:'',
                },
                times:[1,2,3,4,5,6,7],
                charges:['a','b'],
            }
        },
        methods:{
            addTask(){
                if(this.taskForm.task)this.$store.dispatch('auth/postTask', this.taskForm).then(()=>{
                    this.getTaskList()
                    this.taskForm.task=''
                })
            },getTaskList(){
                this.$store.dispatch('auth/getTask').then((result)=>{
                    this.tasks = result
                })
            },
            deleteTask(id){
                this.$store.dispatch('auth/deleteTask',id).then(()=>{
                    this.getTaskList()
                })
            },
            updateTask(id){
                let data = {task:this.tasks.filter((v)=>{return v.id === id})[0].task}
                this.$store.dispatch('auth/updateTask',{id:id,task:data.task}).then(()=>{
                    this.getTaskList()
                })
            },
            updateHowlong(id){
                let data = {howlong:this.tasks.filter((v)=>{return v.id === id})[0].howlong}
                this.$store.dispatch('auth/updateHowlong',{id:id,howlong:data.howlong}).then(()=>{
                    this.getTaskList()
                })
            },
            updateHowtimes(id){
                let data = {howtimes:this.tasks.filter((v)=>{return v.id === id})[0].howtimes}
                this.$store.dispatch('auth/updateHowtimes',{id:id,howtimes:data.howtimes}).then(()=>{
                    this.getTaskList()
                })
            },
            updateCharge(id){
                let data = {charge:this.tasks.filter((v)=>{return v.id === id})[0].charge}
                this.$store.dispatch('auth/updateCharge',{id:id,charge:data.charge}).then(()=>{
                    this.getTaskList()
                })
            },
        },
        mounted() {
            this.getTaskList()
            console.log('Component mounted.')
        }
    }
</script>