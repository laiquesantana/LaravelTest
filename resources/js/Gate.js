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
                return 'Administrador';
                break;
            case 'gerente':
                return 'Secretário'
                break;
            default:
                return 'Usuário Padrão'
                break;
        }

    }

    isDefault() {
        return this.user.tipo === 'default';
    }
    isAdminOrGerente() {
        if (this.user.tipo === 'admin' || this.user.tipo === 'gerente') {
            return true;
        }

    }
    isGerenteOrDefault() {
        if (this.user.tipo === 'default' || this.user.tipo === 'gerente') {
            return true;
        }

    }



}
