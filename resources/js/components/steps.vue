<template>
    <div class="row justify-content-center">
            <div class="col-4 mr-3">
                <div class="card mb-4" v-if="inProcess.length">
                    <div class="card-header">
                        待完成的步骤({{ inProcess.length }}) :
                        <button class="btn btn-sm btn-success float-right" @click="completeAll()">完成全部</button>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="step in inProcess">
                                <span @dblclick="edit(step)">
                                    {{ step.name }}
                                </span>
                                <span class="float-right">
                                    <i class="fa fa-check" @click="toggle(step)"></i>
                                    <i class="fa fa-times" @click="remove(step)"></i>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="form-group">
                            <label v-if="!newStep">要完成当前任务,需要哪些步骤？</label>
                            <input type="text" v-model="newStep" ref="newStep" @keyup.enter="addStep" class="form-control">
                        </div>
                        <button class="btn btn-sm btn-success float-right" v-if="newStep" @click="addStep">添加</button>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card mb-4" v-if="processed.length">
                    <div class="card-header">
                        已完成的步骤({{ processed.length }}) :
                        <button class="btn btn-sm btn-danger float-right" @click="clearCompleted()">清除</button>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="step in processed">
                                <span @dblclick="edit(step)">
                                    {{ step.name }}
                                </span>

                                <span class="float-right">
                                    <i class="fa fa-check" @click="toggle(step)"></i>
                                    <i class="fa fa-times" @click="remove(step)"></i>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default
    {
        props:[
            'route'
        ],
        data(){
            return {
                steps: [
                    {name:'',completion:false}
                ],
                newStep:''
            }
        },
        created(){
            this.fetchSteps()
        },
        computed:{
            inProcess(){
                return this.steps.filter((step)=>{
                    return !step.completion
                })
            },

            processed(){
                return this.steps.filter((step)=>{
                    return step.completion
                })
            }
        },
        methods:{
            fetchSteps(){
                axios.get( this.route ).then((res)=>{
                    this.steps = res.data.steps
                }).catch((err)=>{
                    // alert(`很抱歉，发生错误，\n ${err.response.data.meassage}  \n 错误码：${err.response.status}`)
                })
            },
            addStep(){
                axios.post( this.route, { name: this.newStep }).then((res)=>{
                    this.steps.push(res.data.step)
                    this.newStep = ''

                }).catch((err)=>{
                    // alert(`很抱歉，发生错误，\n ${err.response.data.meassage}  \n 错误码：${err.response.status}`)
                })
            },
            toggle(step){
                step.completion = ! step.completion
            },
            remove(step){
                axios.delete(`${this.route}/${step.id}`).then((res)=>{
                    let i = this.steps.indexOf(step)
                    this.steps.splice(i,1)
                })
            },
            edit(step){
                this.remove(step)
                this.newStep = step.name
                this.$refs.newStep.focus()
            },
            compltetAll(){
                this.inProcess.forEach((step)=>{
                    step.completion = true
                })
            },

            clearCompleted(){
                this.steps = this.inProcess
            }
        }
    }
</script>

<style lang="stylus">

</style>
