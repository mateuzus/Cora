<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Suporte <a href="mailto:contato@includetecnologia.com.br">Falar com suporte</a>
        Versão: {{ config("app.version") }}
    </div>
    <!-- Default to the left -->
    <strong>Copyright © {{ now()->format("Y") }} <a href="https://includetecnolgoia.com.br">Include Tecnologia</a>.</strong> Todos os direitos reservados .

    @yield('footer')
</footer>
