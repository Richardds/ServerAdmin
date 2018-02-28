export const Utils = new class {

    /**
     * Update attributes of existing object.
     *
     * @param mainObject
     * @param object
     */
    updateAttributes(mainObject, object) {
        _.forOwn(mainObject, (value, key) => {
            mainObject[key] = object[key];
        });
    }

    /**
     * Copy attributes of existing object to new object
     *
     * @param copyFromObject
     * @param copyToObject
     */
    copyAttributes(copyFromObject, copyToObject) {
        _.forOwn(copyFromObject, (value, key) => {
            copyToObject[key] = copyFromObject[key];
        });
    }

    /**
     * Generate random password of given length.
     *
     * @param length
     * @returns {string}
     */
    generatePassword(length = 24) {
        return _.times(length, () => _.random(35).toString(36)).join('');
    }

    /**
     * Generate serial number based on current date and iterator.
     *
     * @param i
     * @returns {*}
     */
    generateSerial(i = 1) {
        let date = new Date();
        return ((date.getFullYear() * 100 + date.getMonth() + 1) * 100 + date.getDate()) * 100 + _.min([(i), 99])
    }

    stripObjectNulls(object) {
        let newObject = {};

        Object.keys(object).forEach((key) => {
            if (object[key] != null && object[key] !== '') {
                newObject[key] = object[key];
            }
        });

        return newObject;
    }
};

export class Form {
    constructor(defaultAttributes) {
        this.defaultAttributes = defaultAttributes;
        this.attributes = {};
        Utils.copyAttributes(this.defaultAttributes, this.attributes);
        this.loading = false;
    }

    reset() {
        Utils.updateAttributes(this.attributes, this.defaultAttributes);
    }

    start() {
        this.loading = true;
    }

    finish() {
        this.loading = false;
        this.reset();
    }

    crash(error) {
        this.loading = false;
        console.log(error);
        // TODO: Print error in logger
    }
}

export class ModalForm extends Form {
    constructor(defaultAttributes) {
        super(defaultAttributes);
        this.enabled = false;
    }

    finish() {
        super.finish();
        this.close();
    }

    crash(error) {
        super.crash(error);
        // TODO: Show form fields errors
    }

    open() {
        this.enabled = true;
    }

    close() {
        this.enabled = false;
    }
}

export class ToggleForm extends Form {
    constructor() {
        super({
            enabled: false
        });
    }

    switch(currentState) {
        this.attributes.enabled = !currentState;
    }
}

/**
 * TODO: ...
 */
export class EditForm extends Form {
    constructor(defaultAttributes) {
        super(defaultAttributes);
        this.editing = false;
        this.changed = false;
    }
}
