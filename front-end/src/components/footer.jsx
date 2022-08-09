import React, { Component } from 'react';
import '../styles/footer.css';

class Footer extends Component {
  render() {
    return (
      <div>
        <div className="footer">
          <div>
            <img className='logo' src="/so F (1).png" alt="f-logo" />
          </div>
          <div>
            <div className='icon-container'>
              <img className='icon' src="/phone.svg" alt="phone-icon" />
              <p>+55 21 3XXX XXXX</p>
            </div>
            <div className='icon-container'>
              <img className='icon' src="/email.svg" alt="email-icon" />
              <p>contato@freyesleben.adv.br</p>
            </div>
            <div className='icon-container'>
              <img className='icon' src="/office.svg" alt="office-icon" />
              <p>Rua Nanana, XXX Sala ZZZ - Centro - Rio de Janeiro, RJ</p>
            </div>
          </div>
          <div className='socials-container'>
            <img className='icon' src="/whatsapp.png" alt="whatsapp-icon" />
            <img className='icon' src="/linkedin.png" alt="linkedin-icon" />
            <img className='icon' src="/facebook.png" alt="facebook-icon" />
          </div>
        </div>
      </div>
    );
  }
}

export default Footer;
