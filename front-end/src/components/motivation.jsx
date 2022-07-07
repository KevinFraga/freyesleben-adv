import React, { Component } from "react";

class Motivation extends Component {
    render() {
        return (
            <div>
                <p className="title">E o que nos mantém inspirados</p>
                <ul className="important">
                    <li className="c-text">MISSÃO: Prestar serviços jurídicos com ética e eficácia a fim de auxiliar pessoas a alcançar objetivos.</li>
                    <span className="line-minor" />
                    <li className="c-text">VISÃO: Ser reconhecido como referência no segmento de atuação, oferecendo uma empresa dinâmica, inovadora e eficiente.</li>
                    <span className="line-minor" />
                    <li className="c-text">VALORES: Agir com boa fé e lealdade, Ser excelente naquilo que faz, Aproveitar obstáculos para desenvolver habilidades, Atuar com integridade e ética na condução dos negócios, Ser respeitoso nas relações pessoais e profissionais.</li>
                </ul>
            </div>
        );
    }
}

export default Motivation;
