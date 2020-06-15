<template>
    <div class="card">
        <div class="card-header">
            <div class="form-group">
                <label v-if="!newStep">要完成当前任务,需要哪些步骤？</label>
                <input
                    type="text"
                    v-model="newStep"
                    ref="newStep"
                    @keyup.enter="addStep"
                    class="form-control"
                />
            </div>
            <button
                class="btn btn-sm btn-success float-right"
                v-if="newStep"
                @click="addStep"
            >
                添加
            </button>
        </div>
    </div>
</template>

<script>
import { Hub } from "../event-bus";

export default {
    props: ["route"],
    data() {
        return {
            newStep: ""
        };
    },
    created() {
        Hub.$on("edit", this.edit);
    },
    methods: {
        addStep() {
            axios
                .post(this.route, { name: this.newStep })
                .then(res => {
                    this.$emit("add", res.data.step);
                    this.newStep = "";
                })
                .catch(err => {
                    // alert(`很抱歉，发生错误，\n ${err.response.data.meassage}  \n 错误码：${err.response.status}`)
                });
        },
        edit(step) {
            // console.log(step);
            this.newStep = step.name;
            //focus当前的输入框
            this.$refs.newStep.focus();
        }
    }
};
</script>
