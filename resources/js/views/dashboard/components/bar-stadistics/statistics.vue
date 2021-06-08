<template>
    <div class="stadistics-dashboard">
        <div>{{ name }}</div>
        <div>
            <b-icon class="icon-stadistics" :style="giveColorIcons" :icon="iconName"></b-icon>{{ count }}</div>
    </div>
</template>
<script>
export default {
    props:["name", "number","iconName","color"],
    data(){
        return {
            count: 0,
        }
    },
    mounted() {
        this._setInterval();
    },
    methods: {
        _setInterval: function() {
                this.interval = setInterval(() => {
                    if (this.count === this.number) {
                        clearInterval(this.interval);
                    } else {
                        this.count += 1;
                    }
                }, 0.700);
        },
    },
    computed:{
        giveColorIcons(){
            return {fill: this.color};
        }
    }
}
</script>
<style scoped>
.stadistics-dashboard {
  font-size: 20px;
  text-align: center;
  color: rgba(0, 0, 0, 0.5);
  margin-top: 8px;
  margin-bottom: 8px;
}
.icon-stadistics{
    margin-right: 5px;
    width: 15px;
}
</style>
