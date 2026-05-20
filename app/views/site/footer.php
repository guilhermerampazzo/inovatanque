    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <img src="/logo.svg" alt="Inova Tanque" class="footer-logo">
                    <p>Locação e venda de carretas-tanque com pronta entrega, manutenção própria e seguro incluso.</p>
                </div>
                <div class="footer-col">
                    <h4>Links</h4>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/catalogo">Catálogo</a></li>
                        <li><a href="/sobre">Sobre Nós</a></li>
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="/contato">Contato</a></li>
                        <li><a href="/politica-de-privacidade">Política de Privacidade</a></li>
                        <li><a href="/termos-de-uso">Termos de Uso</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contato</h4>
                    <ul>
                        <li><?= TELEFONE ?></li>
                        <li><?= EMAIL_CONTATO ?></li>
                        <li>Rodovia Prof. Zeferino Vaz (SP 332) — KM 125<br>Santa Terezinha, Paulínia/SP<br>CEP 13140-774</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Redes Sociais</h4>
                    <div class="social-links">
                        <a href="<?= FACEBOOK_URL ?>" target="_blank" rel="noopener">Facebook</a>
                        <a href="<?= INSTAGRAM_URL ?>" target="_blank" rel="noopener">Instagram</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Renato T. Sattin Peças e Implementos Rodoviários ME — CNPJ 08.436.403/0001-90</p>
                <p>&copy; <?= date('Y') ?> Inova Tanque. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
