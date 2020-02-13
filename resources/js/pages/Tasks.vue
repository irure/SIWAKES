<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel toppanel">
                    <router-link to="/" tag="button"class="button sbutton">タスク一覧</router-link>
                    <router-link to="/graph" tag="button"class="button">グラフ</router-link>
                    <router-link to="/charge" tag="button"class="button">担当者変更</router-link>
                </div>
                <div class="panel table-responsive">
                    <table class="table-striped" align="center">
                        <tr>
                            <td>タスク名</td><td>1回/分</td><td>1週間/回</td><td>担当</td>
                        </tr>
                        <tr class="card" v-for="task in tasks">
                            <td><input type="text" class="form-control" id="task" v-model="task.task" @blur="updateTask(task.id)"style="width:8em;"></td>
                            <td><input type="howlong" class="form-control" id="howlong" v-model="task.howlong" @blur="updateHowlong(task.id)" style="width:4em;">分</td>
                            <td><select class="form-control" v-model="task.howtimes" @blur="updateHowtimes(task.id)">
                                <option v-for="time in times">
                                    {{ time }}
                                </option>
                            </select>回</td>
                            <td><select class="form-control" v-model="task.charge" @blur="updateCharge(task.id)">
                                <option v-for="charge in charges">
                                    {{ charge.charge }}
                                </option>
                            </select></td>
                            <td><button type="button" class="btn btn-danger" @click="deleteTask(task.id)">Delete</button></td>
                            </tr>
                            <tr>
                                <input type="text" class="form-control" id="inputtask" v-model="taskForm.task" @blur="addTask" placeholder="新規タスクを追加" style="width:8em;">
                            </tr>
                        </table>
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
                charges:[]
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
            getChargeList(){
                this.$store.dispatch('auth/getCharge').then((result)=>{
                    this.charges = result
                })
            },
            getPart(){
                this.$store.dispatch('auth/getPart').then((result)=>{
                    if(result){
                        this.$router.replace('/Tasks2')
                    }else{
                        this.part = result
                    }
                })
            },
        },
        mounted() {
            this.getPart()
            this.getTaskList()
            this.getChargeList()
            console.log('Component mounted.')
        }
    }
</script>