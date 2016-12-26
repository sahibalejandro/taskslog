<template>
    <div class="control">
        <label class="label" for="date">Date</label>
        <input class="input" type="date" id="date" @input="emitValue($event.target.value)" v-model="date">
    </div>
</template>

<script>
import moment from 'moment';

export default {
    name: 'Date',

    props: ['value'],

    data() {
        return {
            date: null,
        }
    },

    watch: {
        value(value)
        {
            this.date = value;
        }
    },

    created() {
        // The default date is passed in through the "value" property, if no
        // value is passed then we set the default date to today.
        if (this.value == null) {
            this.date = moment().format('YYYY-MM-DD');
        } else {
            this.date = this.value;
        }

        // Notify the parent the new value of date.
        this.emitValue(this.date);
    },

    methods: {
        emitValue(value) {
            this.$emit('input', value);
        }
    }
}
</script>
