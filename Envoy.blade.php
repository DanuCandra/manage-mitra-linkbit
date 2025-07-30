@servers(['production' => ['root@165.22.103.46']])

@setup
    $repo = 'https://github.com/DanuCandra/manage-mitra-linkbit.git';
    $appDir = '/var/www/mitra-linkbit';
    $branch = 'main';

    date_default_timezone_set('Asia/Jakarta');
    $date = date('YmdHis');

    $builds = $appDir . '/sources';
    $deployment = $builds . '/' . $date;

    $serve = $appDir . '/source';
    $env = $appDir . '/.env';
    $storage = $appDir . '/storage';
@endsetup

@story('deploy')
    git
    install
    live
@endstory

@task('git', ['on' => 'production'])
    git clone -b {{ $branch }} "{{ $repo }}" {{ $deployment }}
@endtask

@task('install', ['on' => 'production'])
    cd {{ $deployment }}

    rm -rf {{ $deployment }}/storage

    ln -nfs {{ $env }} {{ $deployment }}/.env

    ln -nfs {{ $storage }} {{ $deployment }}/storage

    composer install --prefer-dist --no-dev

    echo "🚀 Running Migrations..."
    php ./artisan migrate --force || { echo "❌ Migration failed"; exit 1; }

    echo "🚀 Running Seeder..."
    php ./artisan db:seed --class=UserSeeder --force || { echo "❌ Seeding failed"; exit 1; }
    php ./artisan db:seed --class=RoleSeeder --force || { echo "❌ Role seediing failed"; exit 1; }
@endtask

@task('live', ['on' => 'production'])
    cd {{ $deployment }}

    ln -nfs {{ $deployment }} {{ $serve }}

    {{-- sudo su --}}
    chown -R www-data: /var/www

    systemctl restart php8.3-fpm

    systemctl restart nginx
@endtask
