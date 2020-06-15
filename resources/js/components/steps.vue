<template>
    <div class="row justify-content-center">
        <div class="col-4 mr-3">
            <step-list :steps="todos" :route="route">
                <div class="card-header">
                    待完成的步骤({{ todos.length }}) :
                    <button
                        class="btn btn-sm btn-success float-right"
                        @click="completeAll"
                    >
                        完成全部
                    </button>
                </div>
            </step-list>

            <step-input :route="route"></step-input>
        </div>

        <div class="col-4">
            <step-list :steps="dones" :route="route">
                <div class="card-header">
                    已完成的步骤({{ dones.length }}) :
                    <button
                        class="btn btn-sm btn-danger float-right"
                        @click="clearCompleted"
                    >
                        清除
                    </button>
                </div>
            </step-list>
        </div>
    </div>
</template>

<script>
import StepInput from "./step-input";
import StepList from "./step-list";
export default {
    props: {
        route: String,
        todos: Array,
        dones: Array
    },
    components: {
        "step-input": StepInput,
        "step-list": StepList
    },
    methods: {
        edit(step) {
            // 删除当前step
            this.remove(step);
            //输入框中显示当前的step的name
            Hub.$emit("edit", step);
        },
        completeAll() {
            axios.post(`${this.route}/complete`).then(res => {
                window.location.reload();
            });
        },

        clearCompleted() {
            axios.delete(`${this.route}/clearCompleted`).then(res => {
                window.location.reload();
            });
            // this.steps = this.todos
        }
    }
};
</script>

<style lang="stylus"></style>
