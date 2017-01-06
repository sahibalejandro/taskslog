<script src="./reports.js"></script>
<template>
    <div class="section">
        <h3 class="title is-3">Reports</h3>

        <form @submit.prevent="submit">
            <div class="columns is-unique">
                <!-- Start Date -->
                <div class="column is-narrow">
                    <div class="control">
                        <label for="start_date" class="label">Start date</label>
                        <input class="input" type="date" id="start_date" v-model="start_date">
                    </div>
                </div><!-- .column -->

                <!-- End Date -->
                <div class="column is-narrow">
                    <div class="control">
                        <label for="end_date" class="label">End date</label>
                        <input class="input" type="date" id="end_date" v-model="end_date">
                    </div>
                </div><!-- .column -->

                <!-- Account Filter -->
                <div class="column is-narrow">
                    <div class="control">
                        <label for="account" class="label">Account</label>
                        <div class="select">
                            <select id="account" v-model="account_id">
                                <option value="">All accounts</option>
                                <option v-for="account in accounts" :value="account.id" v-text="account.name"></option>
                            </select>
                        </div>
                    </div>
                </div><!-- .column -->

                <!-- Report Button -->
                <div class="column">
                    <label class="label">&nbsp;</label>
                    <button class="button is-primary" type="submit">Get report</button>
                </div><!-- .column -->

            </div><!-- .columns -->
        </form>

        <!-- Entries -->
        <h4 class="title is-4">Entries</h4>

        <div class="box" v-for="group in entriesGroups">
            <h4 class="title is-4">{{ group.account.name }}</h4>
            <h5 class="subtitle">{{ group.totalTime() }} Hrs.</h5>
                <div class="columns">
                    <div class="column"><strong>Task</strong></div>
                    <div class="column"><strong>Hours</strong></div>
                    <div class="column"><strong>Date</strong></div>
                </div>
                <div class="columns" v-for="entry in group.entries">
                    <div class="column">{{ entry.task.name }}</div>
                    <div class="column">{{ parseFloat(entry.hours).toFixed(2) }}</div>
                    <div class="column">{{ entry.humanDate }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
