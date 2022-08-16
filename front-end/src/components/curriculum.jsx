import React, { Component } from 'react';
import '../styles/curriculum.css';

class Curriculum extends Component {
  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );
  
  render() {
    return (
      <div>
        {this.backlogo()}
        <p className="title">QUEM SOMOS</p>
        <ul className="important">
          <li>
            <div className="c-img">
              <img src="/Alexandre_sem_fundo.png" alt="alexandre" />
              <p className="c-name">Alexandre Guerrieri Freyesleben</p>
            </div>
            <div className="c-text">
              <h3>CARGOS E ATUAÇÕES</h3>
              <ul>
                <li>
                  EX-DIRETOR DO SINDICATO NACIONAL DOS AERONAUTAS ATUAL
                  REPRESENTANTE SINDICAL
                </li>
                <li>
                  EX-MEMBRO DA COMISSÃO DE DIREITO AERONÁUTICO DA OAB/RJ
                  (2016/2019)
                </li>
                <li>MEMBRO DA ASSOCIAÇÃO BRASILEIRA DE DIREITO AEROESPACIAL</li>
              </ul>
              <h3>FORMAÇÃO</h3>
              <ul>
                <li>
                  BACHAREL EM DIREITO - UNIVERSIDADE ESTADUAL DO RIO DE JANEIRO
                </li>
                <li>
                  PÓS GRADUAÇÃO LATU SENSU EM AVIAÇÃO CIVIL - UNIVERSIDADE
                  ESTÁCIO DE SÁ
                </li>
                <li>
                  ESPECIALIZAÇÃO EM DIREITO AERONÁUTICO - ASSOCIÇÃO BRASILEIRA
                  DE DIREITO AEROESPACIAL
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div className="c-img">
              <img src="/yago-sem-fundo.png" alt="yago" />
              <p className="c-name">Yago Gomes Freyesleben</p>
            </div>
            <div className="c-text">
              <h3>CARGOS E ATUAÇÕES</h3>
              <ul>
                <li>
                  EXPERIÊNCIA EM EXECUÇÃO TRABALHISTA E PESQUISA PATRIMONIAL
                </li>
              </ul>
              <h3>FORMAÇÃO</h3>
              <ul>
                <li>
                  BACHAREL EM DIREITO - UNIVERSIDADE FEDERAL DO RIO DE JANEIRO
                </li>
                <li>
                  PROGRAMA DE FORMAÇÃO DE INTERMEDIÁRIOS DE FUTEBOL - CBF
                  ACADEMY
                </li>
                <li>
                  PROGRAMA DE FORMAÇÃO DE ADMINISTRADORES JUDICIAIS - ESCOLA
                  SUPERIOR DE ADMINISTRAÇÃO JUDICIÁRIA DO TJRJ
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    );
  }
}

export default Curriculum;
