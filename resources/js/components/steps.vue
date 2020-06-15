<template>
    <div class="row justify-content-center">
        <div class="col-4 mr-3">
            <step-list :steps="inProcess" :route="route">
                  <div class="card-header">
                         待完成的步骤({{ inProcess.length }}) :
                    <button class="btn btn-sm btn-success float-right" @click="completeAll">完成全部</button>
        </div>
            </step-list>

            <step-input :route="route" @add="sync"></step-input>
        </div>

        <div class="col-4">
            <step-list :steps="processed" :route="route">
                 <div class="card-header">
                        已完成的步骤({{ processed.length }}) :
                        <button class="btn btn-sm btn-danger float-right" @click="clearCompleted">清除</button>
                    </div>
            </step-list>

        </div>
    </div>
</template>

<script>
import StepInput from "./step-input";
import StepList from "./step-list";
import { Hub } from "../event-bus";

export default {
    props: ["route"],

    components: {
        "step-input": StepInput,
        "step-list": StepList
    },
    data() {
        return {
            steps: [{ name: "", completion: false }]
        };
    },
    created() {
        this.fetchSteps();
        Hub.$on("remove", this.remove);
    },
    computed: {
        inProcess() {
            return this.steps.filter((step) => {
                return !step.completion;
            });
        },

        processed() {
            return this.steps.filter((step) => {
                return step.completion;
            });
        }
    },
    methods: {
        fetchSteps() {
            axios.get(this.route).then((res) => {
                    this.steps = res.data.steps;
                })
                .catch(err => {
                    // alert(`很抱歉，发生错误，\n ${err.response.data.meassage}  \n 错误码：${err.response.status}`)
                });
        },
        sync(step) {
            this.steps.push(step);
        },
        toggle(step) {
            axios.patch(`${this.route}/${step.id}`, {completion: !step.completion})
                .then((res) => {
                    this.completion = !step.completion
                });
        },
        remove(step) {
            let i = this.steps.indexOf(step);
            this.steps.splice(i, 1)
        },
        edit(step) {
            // 删除当前step
            this.remove(step);
            //输入框中显示当前的step的name
            Hub.$emit("edit", step);
        },
        completeAll() {
            axios.post(`${this.route}/complete`).then((res) => {
                this.inProcess.forEach(step => {
                    step.completion = true;
                });
                // this.fetchSteps()
            });
        },

        clearCompleted() {
            axios.delete(`${this.route}/clearCompleted`).then((res) => {
                this.steps = this.inProcess;
            });
            // this.steps = this.inProcess
        }
    }
};
</script>

<style lang="stylus"></style>
