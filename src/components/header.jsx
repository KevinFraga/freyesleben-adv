import React, { Component } from "react";
import { Link } from 'react-router-dom'
import "../styles/header.css"

class Header extends Component {
    render() {
        return (
            <div className="NavBar">
                <svg width="60px" height="60px"><path d="M41,14H7a2,2,0,0,1,0-4H41A2,2,0,0,1,41,14Z" fill="#004aa2"/><path d="M41,26H7a2,2,0,0,1,0-4H41A2,2,0,0,1,41,26Z" fill="#004aa2"/><path d="M41,38H7a2,2,0,0,1,0-4H41A2,2,0,0,1,41,38Z" fill="#004aa2"/></svg>
                <img src="logo.png" alt="logo" id="logo" />
                <Link to='login'><img src="login-removebg-preview.png" alt="login" id="login" /></Link>
            </div>
        )
    }
}

export default Header;
