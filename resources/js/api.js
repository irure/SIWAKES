"use strict"

const api = {
    getTaskList(){
        return axios.get("/api/task")
        .then(response => (this.info = response.data.bpi))
        .catch(error => console.log(error));
    },
    postTask(task){
        return axios.post("/api/task",task)
        .then(response => (this.info = response.data.bpi))
        .catch(error => console.log(error));
    },
    updateTask(id,task){
        return axios.put("/api/task/" + id,task)
        .then(response => (this.info = response.data.bpi))
        .catch(error => console.log(error));
    },
    deleteTask(id,data){
        return axios.delete("/api/task/" + id)
        .then(response => (this.info = response.data.bpi))
        .catch(error => console.log(error));
    }
}

export default api