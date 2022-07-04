import React, { Component } from "react";

class LoginForm extends Component {
    constructor() {
        super();
        this.state = {
            menu: false,
            loggedIn: false,
            featured: false
        };
        this.toggleMenu = this.toggleMenu.bind(this);
    }

    createInput(name, title) {
        return (
            <div>
                <label htmlFor={name}>{title}</label>
                <input
                    id={name}
                    name={name}
                    type={name}
                    onChange={this.handleChange}
                />
            </div>
        );

    };
}

export default LoginForm;
