<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputtask" v-model="taskForm.task">
                        <button type="button" class="btn btn-primary" @click="addTask">Add</button>
                    </div>
                </div>
                <div class="card" v-for="task in tasks">
                    <div class="card-header">
                        <input type="text" class="form-control" id="task" v-model="task.task">
                        <button type="button" class="btn btn-danger" @click="deleteTask(task.id)">Delete</button>
                        <button type="button" class="btn btn-info" @click="updateTask(task.id)">Update</button>
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
                    task:''
                }
            }
        },
        methods:{
            addTask(){
                if(this.taskForm.task) this.$store.dispatch('auth/postTask', this.taskForm).then(()=>{
                    this.getTaskList()
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
                //let data = {task:this.tasks.filter((v)=>{return v.id === id})[0].task}
                //data._token = document.getElementsByName('csrf-token')[0].content;
                //api.updateTask(id,JSON.stringify(data)).then(()=>{
                let data = {task:this.tasks.filter((v)=>{return v.id === id})[0].task}
                this.$store.dispatch('auth/updateTask',{id:id,task:data.task}).then(()=>{
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