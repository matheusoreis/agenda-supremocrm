document.addEventListener('DOMContentLoaded', function () {

    // Theme Toggle
    (function () {
        var themeToggle = document.getElementById('theme-toggle');
        if (!themeToggle) {
            console.log('Botão de tema não encontrado');
            return;
        }

        console.log('Botão de tema encontrado:', themeToggle);

        function setTheme(isDark) {
            document.documentElement.classList.toggle('dark', isDark);
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        function updateThemeIcons(isDark) {
            var lightIcon = document.getElementById('theme-icon-light');
            var darkIcon = document.getElementById('theme-icon-dark');
            if (lightIcon) lightIcon.classList.toggle('hidden', !isDark);
            if (darkIcon) darkIcon.classList.toggle('hidden', isDark);
        }

        var currentTheme = localStorage.getItem('theme');
        var isDark = currentTheme === 'dark' || (!currentTheme && window.matchMedia('(prefers-color-scheme: dark)').matches);
        setTheme(isDark);
        updateThemeIcons(isDark);

        themeToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var newIsDark = !document.documentElement.classList.contains('dark');
            setTheme(newIsDark);
            updateThemeIcons(newIsDark);
        });
    })();


    // Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Dropdowns
    (function () {
        var stateSelect = document.getElementById('state_id');
        var citySelect = document.getElementById('city_id');

        console.log('stateSelect:', stateSelect);
        console.log('citySelect:', citySelect);

        if (!stateSelect || !citySelect) {
            console.log('Selects não encontrados');
            return;
        }

        var isContactForm = document.querySelector('form[action^="/contacts"]');

        console.log('isContactForm:', isContactForm);

        if (!isContactForm) {
            console.log('Não está em um formulário de contatos');
            return;
        }

        if (stateSelect.value) {
            console.log('Carregando cidades para estado:', stateSelect.value);
            loadCities(stateSelect.value);
        }

        stateSelect.addEventListener('change', function () {
            var stateId = this.value;

            console.log('Estado mudou para:', stateId);

            if (!stateId) {
                citySelect.innerHTML = '<option value="">Selecione um estado</option>';
                citySelect.disabled = false;
                return;
            }

            loadCities(stateId);
        });

        function loadCities(stateId) {
            console.log('Buscando cidades para estado:', stateId);

            citySelect.innerHTML = '<option value="">Carregando...</option>';
            citySelect.disabled = true;

            fetch('/contacts/cities?state_id=' + encodeURIComponent(stateId))
                .then(function (res) {
                    if (!res.ok) {
                        throw new Error('Erro ao carregar cidades');
                    }

                    return res.json();
                })
                .then(function (cities) {
                    console.log('Cidades recebidas:', cities);

                    var options = '<option value="">Selecione uma cidade</option>';

                    cities.forEach(function (city) {
                        options += '<option value="' + city.id + '">' + city.name + '</option>';
                    });

                    citySelect.innerHTML = options;
                    citySelect.disabled = false;
                })
                .catch(function (err) {
                    console.error('Erro ao carregar cidades:', err);
                    citySelect.innerHTML = '<option value="">Erro ao carregar</option>';
                    citySelect.disabled = false;
                });
        }
    })();


    // Dismissible Alerts
    document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
        var closeBtn = alert.querySelector('.alert-close');

        if (!closeBtn) {
            return;
        }

        closeBtn.addEventListener('click', function () {
            alert.style.transition = 'opacity 0.3s ease';
            alert.style.opacity = '0';

            setTimeout(function () {
                alert.remove();
            }, 300);
        });
    });

});