import React, { Component } from "react";
import '../styles/hub.css'

class Hub extends Component {
    constructor() {
        super();
        this.state = {
            slide: 1,
            max: 14
        };
        this.nextSlide = this.nextSlide.bind(this);
        this.prevSlide = this.prevSlide.bind(this);
    }

    nextSlide = () => (this.state.slide === this.state.max) ? this.setState({ slide: 1 }) : this.setState({ slide: this.state.slide + 1 });

    prevSlide = () => (this.state.slide === 1) ? this.setState({ slide: this.state.max }) : this.setState({ slide: this.state.slide - 1 });

    carouselControls() {
        return (
            <div class="carousel-controls">
                <div onClick={this.prevSlide} class="prev-slide">
                    <span>&lsaquo;</span>
                </div>
                <div onClick={this.nextSlide} class="next-slide">
                    <span>&rsaquo;</span>
                </div>
            </div>
        );
    }

    render() {
        const { slide } = this.state;
        return (
            <div>
                <div class="carousel">
                    <ul class="slides">
                        <li className={(slide === 1) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide1.png" />
                            </div>
                            <div className="slide-text">
                                <h2>ALCANCE SEUS OBJETIVOS</h2>
                                <span className="line" />
                                <h1>O JEITO MAIS SEGURO DE ENCONTRAR JUSTIÇA</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 2) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide2.png" />
                            </div>
                            <div className="slide-text">
                                <h2>CONHEÇA AS AÇÕES EM DESTAQUE</h2>
                                <span className="line" />
                                <h1>AS ESPECIALIDADES DOS ADVOGADOS</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 3) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide3.png" />
                            </div>
                            <div className="slide-text">
                                <h2>DIREITOS TRABALHISTAS. HOMOLOGAÇÃO. DIREITO DO CONSUMIDOR. COMPLIANCE. RECURSOS ADMINISTRATIVOS.</h2>
                                <span className="line" />
                                <h1>DIREITO AERONÁUTICO</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 4) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide4.png" />
                            </div>
                            <div className="slide-text">
                                <h2>CONTRATO. INDENIZAÇÃO. DIREITO DO CONSUMIDOR. RESPONSABILIDADE CIVIL. PROPRIEDADE. USUCAPIÃO.</h2>
                                <span className="line" />
                                <h1>DIREITO CIVIL</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 5) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide5.png" />
                            </div>
                            <div className="slide-text">
                                <h2>DIVÓRCIO. PARTILHA DE BENS. PENSÃO ALIMENTÍCIA. VISITAÇÃO. ACORDO PRÉ-NUPCIAL. JUDICIAL E EXTRAJUDICIAL.</h2>
                                <span className="line" />
                                <h1>DIREITO DE FAMÍLIA</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 6) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide6.png" />
                            </div>
                            <div className="slide-text">
                                <h2>NÓS CUIDAMOS DO SEU INVENTÁRIO. TESTAMENTOS & HERANÇAS. JUDICIAL E EXTRAJUDICIAL.</h2>
                                <span className="line" />
                                <h1>DIREITO DE SUCESSÃO</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 7) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide7.png" />
                            </div>
                            <div className="slide-text">
                                <h2>CLT & ESTATUTÁRIO.</h2>
                                <span className="line" />
                                <h1>DIREITO DO TRABALHO</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 8) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide8.png" />
                            </div>
                            <div className="slide-text">
                                <h2>RECUPERAÇÃO JUDICIAL. FALÊNCIA. HABILITAÇÃO E RECLASSIFICAÇÃO DE CRÉDITO. ADMINISTRADOR JUDICIAL.</h2>
                                <span className="line" />
                                <h1>DIREITO EMPRESARIAL</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 9) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide9.png" />
                            </div>
                            <div className="slide-text">
                                <h2>ACOMPANHE O PROCESSO.</h2>
                                <span className="line" />
                                <h1>MASSA FALIDA OU RECUPERAÇÃO JUDICIAL</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 10) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide10.png" />
                            </div>
                            <div className="slide-text">
                                <h2>AGENTE CBF. RECURSO ADMINISTRATIVO.</h2>
                                <span className="line" />
                                <h1>DIREITO DESPORTIVO</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 11) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide11.png" />
                            </div>
                            <div className="slide-text">
                                <h2>INVENTÁRIO E EMPRÉSTIMOS. ACORDOS JUDICIAL E EXTRAJUDICIAL.</h2>
                                <span className="line" />
                                <h1>AERUS</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 12) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide12.png" />
                            </div>
                            <div className="slide-text">
                                <h2>REVISÃO DA CORREÇÃO MONETÁRIA.</h2>
                                <span className="line" />
                                <h1>FGTS</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 13) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide13.png" />
                            </div>
                            <div className="slide-text">
                                <h2>LEI DE INCENTIVO À CULTURA E AO ESPORTE. LEI ROAUNET. FUTEBOL S.A.</h2>
                                <span className="line" />
                                <h1>PROJETO DE LEI DE INCENTIVO À CULTURA E AO DESPORTO</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                        <li className={(slide === 14) ? 'selected' : 'not'}>
                            <div class="slide-image">
                                <img src="slide14.png" />
                            </div>
                            <div className="slide-text">
                                <h2>BENEFÍCIOS EXCLUSIVOS.</h2>
                                <span className="line" />
                                <h1>ÁREA DE CLIENTES CADASTRADOS</h1>
                                <span className="line" />
                            </div>
                            {this.carouselControls()}
                        </li>
                    </ul>
                </div>
            </div>
        );
    }
}

export default Hub;
