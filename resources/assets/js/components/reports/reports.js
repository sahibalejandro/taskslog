import axios from 'axios';
import moment from 'moment';
import {mapGetters} from 'vuex';

class entriesGroup
{
    constructor(account)
    {
        this.account = account;
        this.entries = [];
    }

    hasAccount(account)
    {
        return this.account.id === account.id;
    }

    addEntry(entry)
    {
        entry.humanDate = moment(entry.date).format('dd DD, MMM YYYY');
        this.entries.push(entry);
    }

    totalTime()
    {
        return this.entries.reduce((t, e) => t += parseFloat(e.hours), 0);
    }
}

export default {
    name: 'Reports',

    data()
    {
        return {
            entries: [],
            account_id: '',
            end_date: moment().format('YYYY-MM-DD'),
            start_date: moment().subtract(1, 'week').format('YYYY-MM-DD'),
        };
    },

    computed: {
        // jshint ignore:start
        ...mapGetters(['accounts']),
        // jshint ignore:end

        entriesGroups()
        {
            const groups = [];

            this.entries.forEach(entry => {
                const account = entry.task.account;
                let group = groups.find(group => group.hasAccount(account));

                if (! group) {
                    group = new entriesGroup(account);
                    groups.push(group);
                }

                group.addEntry(entry);
            });

            return groups;
        }
    },

    methods: {
        submit()
        {
            const url = `/api/reports/${this.start_date}/${this.end_date}/${this.account_id}`;

            axios.get(url)
                .then(res => {
                    this.entries = res.data.entries;
                })
                .catch(err => {
                    alert(err.message);
                });
        }
    }
};
