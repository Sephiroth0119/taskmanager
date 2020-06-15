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
import { Message } from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
export default {
    props: {
        route: String
    },
    data() {
        return {
            newStep: ""
        };
    },
    methods: {
        addStep() {
            axios
                .post(this.route, { name: this.newStep })
                .then(res => {
                    window.location.reload();
                    // this.$emit("add", res.data.step);
                    // this.newStep = "";
                })
                .catch(err => {
                    if (err.response.status === 422) {
                        Message.error(err.response.data.errors.name[0]);
                    }
                    // alert(`很抱歉，发生错误，\n ${err.response.data.meassage}  \n 错误码：${err.response.status}`)
                });
        }
    }
};
</script>
