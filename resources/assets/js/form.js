import axios from 'axios';

class Errors {
    /**
     * Constructor
     */
    constructor()
    {
        this.errors = {};
    }

    /**
     * Set errors with a laravel style errors object.
     *
     * @param  {Object} errors
     */
    fill(errors)
    {
        this.errors = errors;
    }

    /**
     * Return true if there is any error.
     *
     * @return {Boolea}
     */
    any()
    {
        return Object.keys(this.errors).length > 0;
    }

    first()
    {
        if (this.any()) {
            const key = Object.keys(this.errors)[0];
            return this.errors[key][0];
        }

        return null;
    }

    clear()
    {
        this.errors = {};
    }
}

class Form {

    constructor(data)
    {
        this.originalData = data;
        this.errors = new Errors();
        this.isLoading = false;

        for (const key in data) {
            this[key] = data[key];
        }
    }

    data()
    {
        const data = {};

        for (const key in this.originalData) {
            data[key] = this[key];
        }

        return data;
    }

    post(url)
    {
        return this.submit('post', url);
    }

    submit(type, url)
    {
        this.errors.clear();
        this.isLoading = true;

        console.log(type, url);

        return new Promise((accept, reject) => {
            axios[type](url, this.data())
                .then(response => {
                    accept(response);
                })
                .catch(error => {
                    reject(error);
                    if (error.response.status == 422) {
                        this.errors.fill(error.response.data);
                    } else {
                        alert(error.message);
                    }
                })
                .then(() => this.isLoading = false);
        });
    }
}

export default Form;
