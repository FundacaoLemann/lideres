<!DOCTYPE html>
<body style="background: #EEE; font-family: sans-serif; font-size: 14px; text-align: center;">
    <div id="container" style="display: block; margin: auto; max-width: 700px; width: 100%;">
        <header style="background: white; padding: 20px;">
            <img src="https://fundacaolemann.org.br/assets/site/images/general/lg__lemann.png" alt="Fundação Lemann" style="display: block; margin: auto;">
        </header>
        <div>
            <h1 style="color: #FC0007; font-weight: bold; padding-top: 20px; text-transform: uppercase;">Encontramos uma vaga com o seu perfil</h1>
            <p style="margin-left: 20%; padding-bottom: 15px; width: 60%;">Nosso banco de oportunidades encontrou uma vaga de alta compatibilidade com o seu perfil. Confira as condições da vaga e boa sorte!</p>
        </div>
        <div style="background: white; padding: 30px;">
            <div style="border: 1px solid #EEE; margin: auto; padding: 20px; position: relative; width: 60%;">
                <div style="background: #F65; border-radius: 5px; color: white; max-width: 100px; padding: 4px 8px; position: absolute; right: 10px; top: 10px;">Match <strong>{{ match }}%</strong></div>
                {{#company_logo}}
                <div style="background-image: url({{ company_logo }}); border: 1px solid #E7E7E7; border-radius: 5px; height: 90px; margin: auto; width: 160px;"></div>
                {{/company_logo}}
                {{^company_logo}}
                <h3>{{ company_name }}</h3>
                {{/company_logo}}
                <p style="color: #222; font-weight: bold;">{{ job_title }}</p>
                <div style="color: #888;">
                    <p>Oferecida por <strong style="color: #083050;">{{ company_name }}</strong> em <strong style="color: #083050;">{{ location }}</strong></p>
                </div>
            </div>
            <div>
                <p style="padding-top: 20px;"><a href="{{ job_url }}" style="background: #083050; border-radius: 5px; color: white; padding: 10px 20px; text-decoration: none;">Veja mais sobre a vaga</a></p>
            </div>
        </div>
        <footer>
            <p style="padding: 20px 0 40px;">
                <a href="https://lideres.fundacaolemann.org.br/vagas/" style="color: #083050; font-weight: bold; text-decoration: none;">Confira outras vagas</a>
            </p>
        </footer>
    </div>
</body>