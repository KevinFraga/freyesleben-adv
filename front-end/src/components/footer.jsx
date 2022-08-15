import React, { Component } from 'react';
import '../styles/footer.css';

class Footer extends Component {
  render() {
    return (
      <div>
        <div className="footer">
          <div>
            <img className="logo" src="/so F (1).png" alt="f-logo" />
          </div>
          <div>
            <div className="icon-container">
              <img className="icon" src="/phone.svg" alt="phone-icon" />
              <p>+55 21 96485-5620</p>
            </div>
            <div className="icon-container">
              <img className="icon" src="/email.svg" alt="email-icon" />
              <p>freyesleben.adv@gmail.com</p>
            </div>
            <div className="icon-container">
              <img className="icon" src="/office.svg" alt="office-icon" />
              <p>
                Rua Leandro Martins 22, sala 603 - Centro - Rio de Janeiro, RJ
              </p>
            </div>
          </div>
          <div className="socials-container">
            <a
              target="_blank"
              rel="noreferrer"
              href="https://wa.me/5521964855620"
            >
              <img className="icon" src="/whatsapp.png" alt="whatsapp-icon" />
            </a>
            <a
              target="_blank"
              rel="noreferrer"
              href="https://linkedin.com"
            >
              <img className="icon" src="/linkedin.png" alt="linkedin-icon" />
            </a>
            <a
              target="_blank"
              rel="noreferrer"
              href="https://facebook.com"
            >
              <img className="icon" src="/facebook.png" alt="facebook-icon" />
            </a>
          </div>
        </div>
      </div>
    );
  }
}

export default Footer;
