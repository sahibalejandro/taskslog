<template>
    <div>
        <div class="columns">
            <div class="column">
                <div class="columns">
                    <div class="column">
                        <date v-model="date"></date>
                    </div>
                    <div class="column is-narrow">
                        <label class="label">&nbsp;</label>
                        <button class="button" type="button" @click="previous" title="Previous day">&lt;</button>
                        <button class="button" type="button" @click="today" title="Today">&bull;</button>
                        <button class="button" type="button" @click="next" title="Next day">&gt;</button>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label class="label">&nbsp;</label>
                    <button class="button is-primary" type="button" @click="showAddEntry = true">Add entry</button>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <entries :entries="entries"></entries>
            </div>
            <div class="column is-one-quarter">
                <div class="title">{{ currentDay }}</div>
                <div class="subtitle">{{ currentMonth }}</div>
                <div class="subtitle">Total:</div>
                <div class="title">{{ totalTimeAnimated }} Hrs.</div>
            </div>
        </div>
        <add-entry v-if="showAddEntry" :default-date="date" @close="showAddEntry = false" @entry-added="entryAdded"></add-entry>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import TWEEN from 'tween.js';
import Date from './date.vue';
import Entries from './entries.vue';
import AddEntry from './add-entry.vue';
import {mapActions, mapGetters} from 'vuex';

export default {
    name: 'App',
    components: {Date, Entries, AddEntry},

    data() {
        return {
            date: null,
            entries: [],
            showAddEntry: false,
            totalTimeAnimated: 0
        }
    },

    created()
    {
        this.loadAccounts();
    },

    watch: {
        date(date, old) {
            this.loadEntries(date);
        },

        totalTime(newValue, oldValue)
        {
            const vm = this;

            function animate(time) {
                requestAnimationFrame(animate);
                TWEEN.update(time);
            }

            new TWEEN.Tween({totalTime: oldValue})
                .to({totalTime: newValue}, 250)
                .onUpdate(function (){
                    vm.totalTimeAnimated = this.totalTime.toFixed(2);
                })
                .start();

            animate();
        }
    },

    computed: {
        ...mapGetters(['entries']),

        currentDay() {
            return moment(this.date).format('dddd DD');
        },

        currentMonth() {
            return moment(this.date).format('MMMM YYYY');
        },

        totalTime()
        {
            let total = 0;

            this.entries.forEach(e => total += parseFloat(e.hours));

            return total;
        }
    },

    methods: {
        ...mapActions(['loadAccounts', 'loadEntries', 'addEntry']),

        entryAdded(entry)
        {
            if (this.date == entry.date) {
                this.$store.commit('ADD_ENTRY', entry);
            } else {
                this.date = entry.date;
            }
        },

        next()
        {
            this.date = moment(this.date).add(1, 'day').format('YYYY-MM-DD');
        },

        previous()
        {
            this.date = moment(this.date).subtract(1, 'day').format('YYYY-MM-DD');
        },

        today()
        {
            this.date = moment().format('YYYY-MM-DD');
        }
    }
}
</script>
