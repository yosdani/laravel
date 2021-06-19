<template>
    <RouterLink :to="options">
        <b-button 
            class="float-right"
            variant="primary" 
            size="sm"
        ><b-icon icon="plus" aria-hidden="true"></b-icon>
        {{ translate('general.button_add') }}
        </b-button>
    </RouterLink>
</template>

<script>
import trans from '../../VueTranslation/Translation';
export default {
    props: ["options"]
}
</script>