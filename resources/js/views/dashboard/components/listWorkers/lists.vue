<template>
    <div>
        <div class="boss-US" v-b-toggle.collapse-1>Daniel Valdes
            <b-badge class="float-right" variant="primary" pill>39</b-badge>
        </div>
        <b-collapse id="collapse-1" class="mt-2">
                <b-list-group>
                    <b-list-group-item>Trabajador 1
                        <b-badge class="float-right" variant="primary" pill>14</b-badge>
                    </b-list-group-item>
                    <b-list-group-item>Trabajador 2
                        <b-badge class="float-right" variant="danger" pill>5</b-badge>
                    </b-list-group-item>
                    <b-list-group-item>Trabajador 3
                        <b-badge class="float-right" variant="danger" pill>2</b-badge>
                    </b-list-group-item>
                    <b-list-group-item>Trabajador 4
                        <b-badge class="float-right" variant="danger" pill>8</b-badge>
                    </b-list-group-item>
                    <b-list-group-item>Trabajador 5
                        <b-badge class="float-right" variant="danger" pill>9</b-badge>
                    </b-list-group-item>
                </b-list-group>
        </b-collapse>

        <div class="boss-US" v-b-toggle.collapse-2>Rene
            <b-badge class="float-right" variant="primary" pill>70</b-badge>
        </div>
        <b-collapse id="collapse-2" class="mt-2">
                <b-list-group>
                    <b-list-group-item>Trabajador 1
                        <b-badge class="float-right" variant="success" pill>20</b-badge>
                    </b-list-group-item>
                    <b-list-group-item>Trabajador 2
                        <b-badge class="float-right" variant="danger" pill>1</b-badge>
                    </b-list-group-item>
                    <b-list-group-item>Trabajador 3
                        <b-badge class="float-right" variant="primary" pill>13</b-badge>
                    </b-list-group-item>
                    <b-list-group-item>Trabajador 4
                        <b-badge class="float-right" variant="success" pill>21</b-badge>
                    </b-list-group-item>
                    <b-list-group-item>Trabajador 5
                        <b-badge class="float-right" variant="primary" pill>15</b-badge>
                    </b-list-group-item>
                </b-list-group>
        </b-collapse>
    </div>
</template>
<script>
export default {

}
</script>
<style scoped>
.boss-US{
    font-size: 20px;
    border-bottom: 1px solid #cccc;
    margin-top: 10px;
    padding-bottom: 10px;
    color: rgba(0, 0, 0, 0.5);
}
</style>
