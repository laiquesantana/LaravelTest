export default class Gate {

    constructor(user) {
        this.user = user;
    }


    isAdmin() {
        return this.user.tipo === 'admin';
    }

    getType() {

        switch (this.user.tipo) {
            case 'admin':
                return 'Admin';
                break;
            default:
                return 'Default User'
                break;
        }

    }

    isDefault() {
        return this.user.tipo === 'default';
    }
    isAdmin() {
        if (this.user.tipo === 'admin' ) {
            return true;
        }

    }



}
