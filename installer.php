<?php
$translations = [
    'en' => [
        'language' => 'Language',
        'title' => 'ObeyGDBrowser Installer',
        'subtitle' => 'Sign in with your GDPS owner account to install ObeyGDBrowser.',
        'ownerTitle' => 'Only the GDPS owner can run this installer.',
        'ownerDescription' => 'Use the owner account from your GDPS database. Moderator and other staff accounts cannot install it.',
        'userName' => 'Username',
        'password' => 'Password',
        'showPassword' => 'Show',
        'hidePassword' => 'Hide',
        'connection' => 'GDPS connection folder (lib)',
        'connectionHint' => 'Folder containing connection.php and generatePass.php, relative to this installer.',
        'install' => 'Install',
        'installing' => 'Installing… Please wait.',
        'support' => 'Support server',
        'errorTitle' => 'Error',
        'releaseError' => 'The installation could not be downloaded or extracted. Please try again or contact the support server.',
        'ownerError' => 'Only the GDPS owner can install ObeyGDBrowser. Sign in with the owner account from your GDPS database.',
        'credentialsError' => 'The username or password is incorrect. Check your GDPS account credentials.',
        'connectionError' => 'The connection folder was not found. Check that it contains connection.php and generatePass.php.',
        'databaseConnectionError' => 'The installer could not connect to the GDPS database. Ask the server owner to check the database service and connection settings, then reload this page.',
        'databaseQueryError' => 'The database could not complete the account check. Ask the server owner to check the database permissions and account tables, then reload this page.',
        'dependencyError' => 'A required PHP component or GDPS function is missing or failed. Ask the server owner to check the PHP extensions and GDPS library files, then reload this page.',
        'authenticationError' => 'The GDPS login check could not be completed. Ask the server owner to check the account verification functions, then reload this page.',
        'rateLimitError' => 'Too many login attempts. Wait a few minutes before trying again.',
        'inactiveAccountError' => 'This GDPS account is not activated. Activate it before trying again.',
        'downloadError' => 'The installation download failed. Check the server connection to GitHub and try again after reloading this page.',
        'archiveError' => 'The installation archive could not be opened or extracted. Ask the server owner to check ZIP support and available disk space, then reload this page.',
        'filesystemError' => 'The installation files could not be written or moved. Ask the server owner to check folder permissions, free disk space and any partially installed files before trying again.',
        'serverError' => 'The installer stopped because of an internal server error. Ask the server owner to check the PHP logs and any partially installed files before trying again.',
        'javascriptError' => 'A page function failed. Reload the page before trying again. If you already submitted the installation, check whether it finished before submitting again.',
        'javascriptUnavailable' => 'The page controls could not start correctly. Reload the page with JavaScript enabled. If you already submitted the installation, check whether it finished before submitting again.',
        'requiredError' => 'Complete the username, password and connection folder when shown before installing.',
        'reload' => 'Reload page',
        'ok' => 'OK',
    ],
    'es' => [
        'language' => 'Idioma',
        'title' => 'Instalador de ObeyGDBrowser',
        'subtitle' => 'Inicia sesión con la cuenta del dueño de tu GDPS para instalar ObeyGDBrowser.',
        'ownerTitle' => 'Solo el dueño del GDPS puede ejecutar este instalador.',
        'ownerDescription' => 'Usa la cuenta del dueño de la base de datos de tu GDPS. Las cuentas de moderadores y otros miembros del equipo no pueden instalarlo.',
        'userName' => 'Usuario',
        'password' => 'Contraseña',
        'showPassword' => 'Mostrar',
        'hidePassword' => 'Ocultar',
        'connection' => 'Carpeta de conexión del GDPS (lib)',
        'connectionHint' => 'Carpeta que contiene connection.php y generatePass.php, relativa a este instalador.',
        'install' => 'Instalar',
        'installing' => 'Instalando… Espera un momento.',
        'support' => 'Servidor de soporte',
        'errorTitle' => 'Error',
        'releaseError' => 'No se pudo descargar o extraer la instalación. Inténtalo de nuevo o contacta con el servidor de soporte.',
        'ownerError' => 'Solo el dueño del GDPS puede instalar ObeyGDBrowser. Inicia sesión con la cuenta del dueño de la base de datos de tu GDPS.',
        'credentialsError' => 'El usuario o la contraseña son incorrectos. Revisa los datos de tu cuenta del GDPS.',
        'connectionError' => 'No se encontró la carpeta de conexión. Comprueba que contenga connection.php y generatePass.php.',
        'databaseConnectionError' => 'El instalador no pudo conectarse a la base de datos del GDPS. Pide al dueño del servidor que revise el servicio de base de datos y la configuración de conexión. Después, recarga esta página.',
        'databaseQueryError' => 'La base de datos no pudo completar la comprobación de la cuenta. Pide al dueño del servidor que revise los permisos de la base de datos y las tablas de cuentas. Después, recarga esta página.',
        'dependencyError' => 'Falta un componente de PHP o una función del GDPS, o no funciona correctamente. Pide al dueño del servidor que revise las extensiones de PHP y los archivos de la librería del GDPS. Después, recarga esta página.',
        'authenticationError' => 'No se pudo completar la comprobación de acceso al GDPS. Pide al dueño del servidor que revise las funciones de verificación de cuentas. Después, recarga esta página.',
        'rateLimitError' => 'Se han realizado demasiados intentos de acceso. Espera unos minutos antes de volver a intentarlo.',
        'inactiveAccountError' => 'Esta cuenta del GDPS no está activada. Actívala antes de volver a intentarlo.',
        'downloadError' => 'Falló la descarga de la instalación. Revisa la conexión del servidor con GitHub y vuelve a intentarlo después de recargar esta página.',
        'archiveError' => 'No se pudo abrir o extraer el archivo de instalación. Pide al dueño del servidor que revise el soporte ZIP y el espacio disponible. Después, recarga esta página.',
        'filesystemError' => 'No se pudieron escribir o mover los archivos de instalación. Pide al dueño del servidor que revise los permisos de las carpetas, el espacio disponible y cualquier instalación parcial antes de volver a intentarlo.',
        'serverError' => 'El instalador se detuvo por un error interno del servidor. Pide al dueño del servidor que revise los registros de PHP y cualquier instalación parcial antes de volver a intentarlo.',
        'javascriptError' => 'Una función de la página ha fallado. Recarga la página antes de volver a intentarlo. Si ya enviaste la instalación, comprueba si terminó antes de enviarla otra vez.',
        'javascriptUnavailable' => 'Los controles de la página no pudieron iniciarse correctamente. Recarga la página con JavaScript habilitado. Si ya enviaste la instalación, comprueba si terminó antes de enviarla otra vez.',
        'requiredError' => 'Completa el usuario, la contraseña y la carpeta de conexión cuando aparezca antes de instalar.',
        'reload' => 'Recargar página',
        'ok' => 'Aceptar',
    ],
    'ru' => [
        'language' => 'Язык',
        'title' => 'Установка ObeyGDBrowser',
        'subtitle' => 'Войдите в аккаунт владельца GDPS, чтобы установить ObeyGDBrowser.',
        'ownerTitle' => 'Только владелец GDPS может запустить установщик.',
        'ownerDescription' => 'Используйте аккаунт владельца из базы данных вашего GDPS. Модераторы и другие сотрудники не могут выполнить установку.',
        'userName' => 'Имя пользователя',
        'password' => 'Пароль',
        'showPassword' => 'Показать',
        'hidePassword' => 'Скрыть',
        'connection' => 'Папка подключения GDPS (lib)',
        'connectionHint' => 'Папка с файлами connection.php и generatePass.php относительно установщика.',
        'install' => 'Установить',
        'installing' => 'Установка… Пожалуйста, подождите.',
        'support' => 'Сервер поддержки',
        'errorTitle' => 'Ошибка',
        'releaseError' => 'Не удалось скачать или распаковать установку. Повторите попытку или обратитесь на сервер поддержки.',
        'ownerError' => 'Только владелец GDPS может установить ObeyGDBrowser. Войдите в аккаунт владельца из базы данных вашего GDPS.',
        'credentialsError' => 'Неверное имя пользователя или пароль. Проверьте данные аккаунта GDPS.',
        'connectionError' => 'Папка подключения не найдена. Проверьте наличие файлов connection.php и generatePass.php.',
        'databaseConnectionError' => 'Установщик не смог подключиться к базе данных GDPS. Попросите владельца сервера проверить работу базы данных и настройки подключения, затем обновите страницу.',
        'databaseQueryError' => 'База данных не смогла завершить проверку аккаунта. Попросите владельца сервера проверить права доступа и таблицы аккаунтов, затем обновите страницу.',
        'dependencyError' => 'Необходимый компонент PHP или функция GDPS отсутствует либо работает неправильно. Попросите владельца сервера проверить расширения PHP и файлы библиотеки GDPS, затем обновите страницу.',
        'authenticationError' => 'Не удалось завершить проверку входа в GDPS. Попросите владельца сервера проверить функции проверки аккаунтов, затем обновите страницу.',
        'rateLimitError' => 'Слишком много попыток входа. Подождите несколько минут и повторите попытку.',
        'inactiveAccountError' => 'Этот аккаунт GDPS не активирован. Активируйте его перед повторной попыткой.',
        'downloadError' => 'Не удалось скачать установку. Проверьте подключение сервера к GitHub, обновите страницу и повторите попытку.',
        'archiveError' => 'Не удалось открыть или распаковать архив установки. Попросите владельца сервера проверить поддержку ZIP и свободное место, затем обновите страницу.',
        'filesystemError' => 'Не удалось записать или переместить файлы установки. Попросите владельца сервера проверить права доступа к папкам, свободное место и частично установленные файлы перед повторной попыткой.',
        'serverError' => 'Установщик остановлен из-за внутренней ошибки сервера. Попросите владельца сервера проверить журналы PHP и частично установленные файлы перед повторной попыткой.',
        'javascriptError' => 'Одна из функций страницы завершилась с ошибкой. Обновите страницу перед повторной попыткой. Если установка уже отправлена, проверьте её завершение, прежде чем отправлять её снова.',
        'javascriptUnavailable' => 'Не удалось запустить элементы управления страницы. Обновите страницу с включённым JavaScript. Если установка уже отправлена, проверьте её завершение, прежде чем отправлять её снова.',
        'requiredError' => 'Перед установкой заполните имя пользователя, пароль и папку подключения, если она указана.',
        'reload' => 'Обновить страницу',
        'ok' => 'ОК',
    ],
];

$workflowTranslations = [
    'en' => [
        'temporaryStorageError' => 'PHP cannot use a private temporary folder. Ask the host to configure a writable sys_temp_dir or upload_tmp_dir outside the public directory and permitted by open_basedir. Send the error code and support log.',
        'permissionError' => 'PHP was denied access to a file or folder. Check ownership and write permissions for the PHP service account. Send the error code and support log.',
        'hostingRestrictionError' => 'The PHP open_basedir restriction blocked a file operation. Ask the host to permit the installation and private temporary folders. Send the error code and support log.',
        'readOnlyError' => 'The filesystem is read-only. Ask the host to provide writable installation and private temporary folders.',
        'quotaError' => 'The hosting disk quota was exceeded. Free space or ask the host to increase the quota before trying again.',
        'signIn' => 'Sign in', 'repairTitle' => 'Repair ObeyGDBrowser', 'selectionHint' => 'Choose a version and review the download before confirming.',
        'branch' => 'Version channel', 'stableBranch' => 'Stable', 'betaBranch' => 'Pre-release (beta)', 'masterBranch' => 'Unstable (main)',
        'betaWarning' => 'Pre-release versions may contain incomplete features and bugs.', 'masterWarning' => 'The main branch is intended for development and may be unstable.',
        'customPath' => 'Use a different installation folder', 'target' => 'Installation folder',
        'targetHint' => 'Use a relative folder inside the directory containing this installer.',
        'manualWarning' => 'A custom folder requires manual configuration of the browser connection and paths through SFTP after installation.',
        'review' => 'Review download', 'version' => 'Version', 'downloadSize' => 'Download', 'unpackedSize' => 'Extracted files',
        'downloadExact' => '{size} MB', 'downloadEstimated' => 'Up to {size} MB (estimate; GitHub does not report the ZIP size)',
        'changes' => 'Changes', 'noChanges' => 'No release notes were provided.',
        'verificationDigest' => 'The archive SHA-256 and file hashes will be checked against GitHub.',
        'verificationCommit' => 'The files will be checked against the selected GitHub commit. GitHub does not publish a SHA-256 for this source archive.',
        'confirmation' => 'Confirm installation', 'confirmationText' => 'I accept this download and installation. Once started, the version and destination cannot be changed or cancelled.',
        'confirmInstall' => 'Confirm and install', 'backSelection' => 'Change selection',
        'progressTitle' => 'Installation progress', 'downloading' => 'Downloading', 'verifying' => 'Verifying hashes',
        'extracting' => 'Extracting files', 'placing' => 'Installing files', 'finalizing' => 'Finalizing installation',
        'retrying' => 'Preparing the second and final extraction/install attempt', 'complete' => 'Installation completed.',
        'completeManual' => 'Installation completed. Configure the connection and paths through SFTP before using the browser.',
        'openBrowser' => 'Open browser', 'errorCode' => 'Error code', 'logLabel' => 'Support log (Base64)',
        'copyLog' => 'Copy log', 'copiedLog' => 'Log copied.', 'copyFallback' => 'Select and copy the log manually.',
        'logHint' => 'Base64 is encoding, not encryption. This log contains only diagnostic codes and non-sensitive data. It is also available as browser_installer.log through SFTP.',
        'fetching' => 'Loading version information…', 'notCancelable' => 'The server will continue if you close this page. Do not submit another installation.',
        'sessionError' => 'Your installer session is missing or expired. Reload the page and sign in again.',
        'requestError' => 'The request could not be accepted. Reload the page and review the selected options.',
        'pathError' => 'This installation folder cannot be used. Choose a relative folder without parent paths or symbolic links.',
        'lockedError' => 'An installation has already been accepted or is running. Its version and destination cannot be changed.',
        'confirmationError' => 'The download review expired or was not confirmed. Review the version again before installing.',
        'verificationError' => 'The download could not be verified against GitHub. No installation files were accepted. Report the error code to support.',
        'githubRejectedError' => 'GitHub rejected the request or imposed a request limit. Wait before trying again. Do not repeatedly submit requests.',
        'memoryError' => 'The server ran out of available memory. Ask the server owner to check the PHP memory limit before trying again.',
        'storageError' => 'There is not enough free disk space, or the download exceeds the installer safety limit. Ask the server owner to check the available storage.',
        'placementError' => 'Extraction or file installation failed twice. No further automatic attempts will be made. Send the error code and support log to support.',
        'rollbackError' => 'The previous files could not be fully restored. Stop using the installer and ask support to inspect the installation and retained backup through SFTP.',
        'noReleaseError' => 'No version is available for this channel. Choose another channel.',
        'streamError' => 'The connection to the progress stream was interrupted. The server may still be installing. Check its status before starting anything else.',
        'requiresJavascript' => 'JavaScript is required to review and confirm the installation safely.',
    ],
    'es' => [
        'temporaryStorageError' => 'PHP no puede usar una carpeta temporal privada. Pide al alojamiento configurar sys_temp_dir o upload_tmp_dir con permisos de escritura, fuera del directorio público y permitido por open_basedir. Envía el código y el registro a soporte.',
        'permissionError' => 'PHP no tiene permiso para acceder a un archivo o carpeta. Revisa el propietario y los permisos de escritura de la cuenta que ejecuta PHP. Envía el código y el registro a soporte.',
        'hostingRestrictionError' => 'La restricción open_basedir de PHP bloqueó una operación de archivos. Pide al alojamiento permitir la carpeta de instalación y el temporal privado. Envía el código y el registro a soporte.',
        'readOnlyError' => 'El sistema de archivos es de solo lectura. Pide al alojamiento habilitar escritura en la carpeta de instalación y el temporal privado.',
        'quotaError' => 'Se agotó la cuota de disco del alojamiento. Libera espacio o pide ampliar la cuota antes de volver a intentarlo.',
        'signIn' => 'Iniciar sesión', 'repairTitle' => 'Corregir instalación de ObeyGDBrowser', 'selectionHint' => 'Elige una versión y revisa la descarga antes de confirmar.',
        'branch' => 'Canal de versión', 'stableBranch' => 'Estable', 'betaBranch' => 'Pre-release (beta)', 'masterBranch' => 'Inestable (main)',
        'betaWarning' => 'Las versiones preliminares pueden tener funciones incompletas y errores.', 'masterWarning' => 'La rama main está destinada al desarrollo y puede ser inestable.',
        'customPath' => 'Usar otra carpeta de instalación', 'target' => 'Carpeta de instalación',
        'targetHint' => 'Usa una carpeta relativa dentro del directorio que contiene este instalador.',
        'manualWarning' => 'Una carpeta personalizada requiere configurar manualmente la conexión y las rutas del browser mediante SFTP al terminar.',
        'review' => 'Revisar descarga', 'version' => 'Versión', 'downloadSize' => 'Descarga', 'unpackedSize' => 'Archivos extraídos',
        'downloadExact' => '{size} MB', 'downloadEstimated' => 'Hasta {size} MB (estimación; GitHub no informa el tamaño del ZIP)',
        'changes' => 'Cambios', 'noChanges' => 'Esta versión no incluye notas de cambios.',
        'verificationDigest' => 'Se comprobarán el SHA-256 del archivo y los hashes de sus archivos con GitHub.',
        'verificationCommit' => 'Se comprobarán los archivos contra el commit elegido de GitHub. GitHub no publica un SHA-256 para este ZIP de código fuente.',
        'confirmation' => 'Confirmar instalación', 'confirmationText' => 'Acepto esta descarga e instalación. Una vez iniciada, no se podrá cancelar ni cambiar la versión o el destino.',
        'confirmInstall' => 'Confirmar e instalar', 'backSelection' => 'Cambiar selección',
        'progressTitle' => 'Progreso de instalación', 'downloading' => 'Descargando', 'verifying' => 'Verificando hashes',
        'extracting' => 'Extrayendo archivos', 'placing' => 'Instalando archivos', 'finalizing' => 'Finalizando instalación',
        'retrying' => 'Preparando el segundo y último intento de extracción e instalación', 'complete' => 'Instalación completada.',
        'completeManual' => 'Instalación completada. Configura la conexión y las rutas mediante SFTP antes de usar el browser.',
        'openBrowser' => 'Abrir browser', 'errorCode' => 'Código de error', 'logLabel' => 'Registro para soporte (Base64)',
        'copyLog' => 'Copiar registro', 'copiedLog' => 'Registro copiado.', 'copyFallback' => 'Selecciona y copia manualmente el registro.',
        'logHint' => 'Base64 codifica, no cifra. Este registro solo contiene códigos de diagnóstico y datos no sensibles. También está disponible como browser_installer.log mediante SFTP.',
        'fetching' => 'Obteniendo información de la versión…', 'notCancelable' => 'El servidor continuará aunque cierres esta página. No envíes otra instalación.',
        'sessionError' => 'La sesión del instalador no existe o ha caducado. Recarga la página e inicia sesión de nuevo.',
        'requestError' => 'No se pudo aceptar la solicitud. Recarga la página y revisa las opciones seleccionadas.',
        'pathError' => 'No se puede usar esa carpeta de instalación. Elige una carpeta relativa sin rutas superiores ni enlaces simbólicos.',
        'lockedError' => 'Ya se aceptó una instalación o hay una en curso. No se puede cambiar su versión ni su destino.',
        'confirmationError' => 'La revisión de la descarga ha caducado o no se confirmó. Revisa la versión otra vez antes de instalar.',
        'verificationError' => 'No se pudo verificar la descarga con GitHub. No se aceptaron archivos para la instalación. Comunica el código de error a soporte.',
        'githubRejectedError' => 'GitHub rechazó la solicitud o aplicó un límite de peticiones. Espera antes de volver a intentarlo. No envíes solicitudes repetidamente.',
        'memoryError' => 'El servidor se quedó sin memoria disponible. Pide al dueño que revise el límite de memoria de PHP antes de volver a intentarlo.',
        'storageError' => 'No hay suficiente espacio libre o la descarga supera el límite de seguridad del instalador. Pide al dueño del servidor que revise el almacenamiento disponible.',
        'placementError' => 'La extracción o instalación de archivos falló dos veces. No habrá más intentos automáticos. Envía el código de error y el registro a soporte.',
        'rollbackError' => 'No se pudieron restaurar todos los archivos anteriores. Deja de usar el instalador y pide a soporte que revise la instalación y la copia conservada mediante SFTP.',
        'noReleaseError' => 'No hay una versión disponible para este canal. Elige otro canal.',
        'streamError' => 'Se interrumpió la conexión con el progreso. El servidor podría seguir instalando. Comprueba su estado antes de iniciar otra operación.',
        'requiresJavascript' => 'Se necesita JavaScript para revisar y confirmar la instalación de forma segura.',
    ],
    'ru' => [
        'temporaryStorageError' => 'PHP не может использовать приватную временную папку. Попросите хостинг настроить доступную для записи sys_temp_dir или upload_tmp_dir вне публичного каталога и разрешить её в open_basedir. Передайте код ошибки и журнал поддержке.',
        'permissionError' => 'PHP не имеет доступа к файлу или папке. Проверьте владельца и права записи для учётной записи службы PHP. Передайте код ошибки и журнал поддержке.',
        'hostingRestrictionError' => 'Ограничение PHP open_basedir заблокировало операцию с файлами. Попросите хостинг разрешить папку установки и приватную временную папку. Передайте код ошибки и журнал поддержке.',
        'readOnlyError' => 'Файловая система доступна только для чтения. Попросите хостинг разрешить запись в папку установки и приватную временную папку.',
        'quotaError' => 'Превышена дисковая квота хостинга. Освободите место или попросите увеличить квоту перед повторной попыткой.',
        'signIn' => 'Войти', 'repairTitle' => 'Восстановление ObeyGDBrowser', 'selectionHint' => 'Выберите версию и проверьте загрузку перед подтверждением.',
        'branch' => 'Канал версии', 'stableBranch' => 'Стабильная', 'betaBranch' => 'Предварительная (бета)', 'masterBranch' => 'Нестабильная (main)',
        'betaWarning' => 'Предварительные версии могут содержать незавершённые функции и ошибки.', 'masterWarning' => 'Ветка main предназначена для разработки и может работать нестабильно.',
        'customPath' => 'Использовать другую папку установки', 'target' => 'Папка установки',
        'targetHint' => 'Укажите относительную папку внутри каталога с установщиком.',
        'manualWarning' => 'После установки в другую папку потребуется вручную настроить подключение и пути браузера через SFTP.',
        'review' => 'Проверить загрузку', 'version' => 'Версия', 'downloadSize' => 'Загрузка', 'unpackedSize' => 'Распакованные файлы',
        'downloadExact' => '{size} МБ', 'downloadEstimated' => 'До {size} МБ (оценка; GitHub не сообщает размер ZIP)',
        'changes' => 'Изменения', 'noChanges' => 'Описание изменений отсутствует.',
        'verificationDigest' => 'SHA-256 архива и хеши файлов будут проверены по данным GitHub.',
        'verificationCommit' => 'Файлы будут проверены по выбранному коммиту GitHub. GitHub не публикует SHA-256 для этого архива исходного кода.',
        'confirmation' => 'Подтверждение установки', 'confirmationText' => 'Я принимаю эту загрузку и установку. После запуска нельзя отменить установку или изменить версию и папку.',
        'confirmInstall' => 'Подтвердить и установить', 'backSelection' => 'Изменить выбор',
        'progressTitle' => 'Ход установки', 'downloading' => 'Загрузка', 'verifying' => 'Проверка хешей',
        'extracting' => 'Распаковка файлов', 'placing' => 'Установка файлов', 'finalizing' => 'Завершение установки',
        'retrying' => 'Подготовка второй и последней попытки распаковки и установки', 'complete' => 'Установка завершена.',
        'completeManual' => 'Установка завершена. Перед использованием настройте подключение и пути через SFTP.',
        'openBrowser' => 'Открыть браузер', 'errorCode' => 'Код ошибки', 'logLabel' => 'Журнал для поддержки (Base64)',
        'copyLog' => 'Скопировать журнал', 'copiedLog' => 'Журнал скопирован.', 'copyFallback' => 'Выделите и скопируйте журнал вручную.',
        'logHint' => 'Base64 — кодирование, а не шифрование. Журнал содержит только диагностические коды и несекретные данные. Он также доступен в файле browser_installer.log через SFTP.',
        'fetching' => 'Получение сведений о версии…', 'notCancelable' => 'Сервер продолжит работу, даже если закрыть страницу. Не запускайте другую установку.',
        'sessionError' => 'Сессия установщика отсутствует или истекла. Обновите страницу и войдите снова.',
        'requestError' => 'Не удалось принять запрос. Обновите страницу и проверьте выбранные параметры.',
        'pathError' => 'Эту папку нельзя использовать. Выберите относительную папку без переходов к родительским каталогам и символических ссылок.',
        'lockedError' => 'Установка уже принята или выполняется. Изменить версию и папку нельзя.',
        'confirmationError' => 'Сведения о загрузке устарели или установка не подтверждена. Проверьте версию ещё раз.',
        'verificationError' => 'Не удалось проверить загрузку по данным GitHub. Файлы не допущены к установке. Сообщите код ошибки в поддержку.',
        'githubRejectedError' => 'GitHub отклонил запрос или ограничил их количество. Подождите перед новой попыткой и не отправляйте повторные запросы.',
        'memoryError' => 'На сервере закончилась доступная память. Попросите владельца проверить ограничение памяти PHP перед повторной попыткой.',
        'storageError' => 'Недостаточно свободного места или загрузка превышает безопасный размер. Попросите владельца сервера проверить хранилище.',
        'placementError' => 'Распаковка или установка файлов завершилась ошибкой дважды. Автоматических попыток больше не будет. Отправьте код ошибки и журнал в поддержку.',
        'rollbackError' => 'Не удалось восстановить все прежние файлы. Прекратите установку и попросите поддержку проверить файлы и сохранённую копию через SFTP.',
        'noReleaseError' => 'Для этого канала нет доступной версии. Выберите другой канал.',
        'streamError' => 'Соединение с потоком прогресса прервано. Сервер может продолжать установку. Проверьте её состояние, прежде чем начинать новую операцию.',
        'requiresJavascript' => 'Для безопасной проверки и подтверждения установки требуется JavaScript.',
    ],
];
foreach ($workflowTranslations as $translationLanguage => $workflowMessages) {
    $translations[$translationLanguage] = array_merge($translations[$translationLanguage], $workflowMessages);
}


$language = $_POST['lang'] ?? $_GET['lang'] ?? 'en';
if (!is_string($language) || !isset($translations[$language])) {
    $language = 'en';
}
class InstallerFailure extends \RuntimeException {
    public $messageKey;
    public $errorCode;
    public $httpStatus;
    public $details;

    public function __construct($messageKey, $errorCode = 'OGDW-INTERNAL', $httpStatus = 500, $details = []) {
        $this->messageKey = $messageKey;
        $this->errorCode = $errorCode;
        $this->httpStatus = $httpStatus;
        $this->details = $details;
        parent::__construct($messageKey);
    }
}

function installerAlertKeys() {
    return [
        1 => 'releaseError', 2 => 'ownerError', 3 => 'credentialsError', 4 => 'connectionError',
        5 => 'databaseConnectionError', 6 => 'databaseQueryError', 7 => 'dependencyError',
        8 => 'authenticationError', 9 => 'rateLimitError', 10 => 'inactiveAccountError',
        11 => 'downloadError', 12 => 'archiveError', 13 => 'filesystemError', 14 => 'serverError',
        15 => 'verificationError', 16 => 'githubRejectedError', 17 => 'memoryError', 18 => 'storageError',
        19 => 'placementError', 20 => 'rollbackError', 21 => 'sessionError', 22 => 'requestError',
        23 => 'pathError', 24 => 'lockedError', 25 => 'confirmationError', 26 => 'noReleaseError',
        27 => 'temporaryStorageError', 28 => 'permissionError', 29 => 'hostingRestrictionError',
        30 => 'readOnlyError', 31 => 'quotaError',
    ];
}

function installerFilesystemFailure($message, $operation = '', $area = 'filesystem') {
    $operations = ['is_link', 'is_file', 'is_dir', 'file_exists', 'realpath', 'mkdir', 'fopen', 'fwrite', 'fread', 'fclose', 'flock', 'fflush', 'ftruncate', 'file_put_contents', 'file_get_contents', 'copy', 'rename', 'unlink', 'rmdir', 'scandir', 'filesize', 'chmod', 'disk_free_space', 'hash_file'];
    if ($operation === '' && preg_match('/^([a-z_]+)\(/i', $message, $match)) {
        $operation = strtolower($match[1]);
    }
    if (!in_array($operation, $operations, true)) {
        return null;
    }
    $reason = 'operation-failed';
    $key = 'filesystemError';
    foreach ([
        'open_basedir' => ['open-basedir', 'hostingRestrictionError'],
        'permission denied' => ['permission-denied', 'permissionError'],
        'operation not permitted' => ['operation-not-permitted', 'permissionError'],
        'read-only file system' => ['read-only', 'readOnlyError'],
        'no space left' => ['disk-full', 'storageError'],
        'disk quota exceeded' => ['quota-exceeded', 'quotaError'],
        'no such file or directory' => ['not-found', 'filesystemError'],
        'too many open files' => ['file-limit', 'filesystemError'],
    ] as $pattern => $result) {
        if (stripos($message, $pattern) !== false) {
            list($reason, $key) = $result;
            break;
        }
    }
    $details = ['operation' => str_replace('_', '-', $operation), 'area' => $area, 'reason' => $reason];
    return new InstallerFailure($key, 'OGDW-FS-' . strtoupper($details['operation'] . '-' . $reason), 500, $details);
}

function installerFilesystemAttempt($operation, $area, $callback, &$failure) {
    $failure = installerFilesystemFailure('', $operation, $area);
    set_error_handler(function ($severity, $message, $file, $line) use ($operation, $area, &$failure) {
        $failure = installerFilesystemFailure($message, $operation, $area);
        $failure->details['sourceLine'] = $line;
        return true;
    });
    try {
        return $callback();
    } finally {
        restore_error_handler();
    }
}

function installerFailureKey($failure, $stage) {
    if ($failure instanceof InstallerFailure) {
        return $failure->messageKey;
    }
    if ($failure instanceof \PDOException) {
        $driverCode = isset($failure->errorInfo[1]) ? (int) $failure->errorInfo[1] : 0;
        if ($stage === 'connection' || substr((string) $failure->getCode(), 0, 2) === '08' || in_array($driverCode, [1044, 1045, 1049, 2002, 2003, 2006], true)) {
            return 'databaseConnectionError';
        }
        return 'databaseQueryError';
    }
    if ($failure instanceof \Error) {
        return 'dependencyError';
    }
    $stageKeys = [
        'session' => 'sessionError',
        'connection' => 'databaseConnectionError',
        'authentication' => 'authenticationError',
        'account' => 'databaseQueryError',
        'release' => 'releaseError',
        'download' => 'downloadError',
        'downloading' => 'downloadError',
        'verifying' => 'verificationError',
        'archive' => 'archiveError',
        'files' => 'filesystemError',
    ];
    return $stageKeys[$stage] ?? 'serverError';
}


function installerSafeRelativePath($path) {
    if (!is_string($path) || $path === '' || strlen($path) > 512 || $path[0] === '/' || preg_match('/[\x00-\x1f\x7f\\\\:*?"<>|]/', $path)) {
        return false;
    }
    foreach (explode('/', $path) as $part) {
        if ($part === '' || $part === '.' || $part === '..' || preg_match('/[. ]$/', $part) || preg_match('/^(?:CON|PRN|AUX|NUL|COM[1-9]|LPT[1-9])(?:\.|$)/i', $part)) {
            return false;
        }
    }
    return true;
}

function installerIsBrowser($path) {
    $markers = (int) is_file($path . '/_init_.php') + (int) is_file($path . '/assets/css/browser.css') + (int) is_file($path . '/gdps_settings.json');
    return $markers >= 2;
}

function installerTarget($relative, $allowCustom) {
    $default = installerIsBrowser(__DIR__) ? '.' : 'browser';
    if (!$allowCustom && $relative !== $default) {
        throw new InstallerFailure('pathError', 'OGDW-PATH-DISABLED', 400);
    }
    if ($relative === '.') {
        if (!installerIsBrowser(__DIR__)) {
            throw new InstallerFailure('pathError', 'OGDW-PATH-ROOT', 400);
        }
        return ['relative' => '.', 'path' => __DIR__, 'repair' => true];
    }
    if (!installerSafeRelativePath($relative) || strlen($relative) > 160) {
        throw new InstallerFailure('pathError', 'OGDW-PATH-INVALID', 400);
    }
    $current = __DIR__;
    foreach (explode('/', $relative) as $part) {
        $current .= '/' . $part;
        $resolved = realpath($current);
        $matches = $resolved === false || strcasecmp(str_replace('\\', '/', $resolved), str_replace('\\', '/', $current)) === 0;
        if (!$matches || is_link($current) || file_exists($current) && !is_dir($current)) {
            throw new InstallerFailure('pathError', 'OGDW-PATH-UNSAFE', 400);
        }
    }
    return ['relative' => $relative, 'path' => $current, 'repair' => installerIsBrowser($current) || $relative === 'browser' && is_dir($current)];
}

function installerWorkRoot() {
    $candidates = array_unique([sys_get_temp_dir(), (string) ini_get('upload_tmp_dir')]);
    $publicRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? __DIR__) ?: __DIR__;
    $publicRoot = rtrim(str_replace('\\', '/', $publicRoot), '/') . '/';
    $failure = new InstallerFailure('temporaryStorageError', 'OGDW-TEMP-UNAVAILABLE', 500, ['area' => 'temporary', 'reason' => 'not-writable']);
    foreach ($candidates as $candidate) {
        if ($candidate === '') {
            continue;
        }
        $parent = installerFilesystemAttempt('realpath', 'temporary', function () use ($candidate) {
            return realpath($candidate);
        }, $failure);
        if ($parent === false) {
            if ($failure->details['reason'] === 'operation-failed') {
                $failure->details['reason'] = 'not-found';
            }
            $failure->messageKey = 'temporaryStorageError';
            $failure->errorCode = 'OGDW-TEMP-' . strtoupper($failure->details['reason']);
            continue;
        }
        $normalized = rtrim(str_replace('\\', '/', $parent), '/') . '/';
        $isPublic = PHP_OS_FAMILY === 'Windows' ? stripos($normalized, $publicRoot) === 0 : strpos($normalized, $publicRoot) === 0;
        if ($isPublic) {
            $failure = new InstallerFailure('temporaryStorageError', 'OGDW-TEMP-PUBLIC', 500, ['area' => 'temporary', 'reason' => 'public-directory']);
            continue;
        }
        $root = rtrim($parent, '/\\') . '/ogdw-installer-' . substr(hash('sha256', __DIR__), 0, 24);
        if (is_link($root) || file_exists($root) && !is_dir($root)) {
            throw new InstallerFailure('filesystemError', 'OGDW-WORK-UNSAFE');
        }
        $ready = installerFilesystemAttempt('mkdir', 'temporary', function () use ($root) {
            return (is_dir($root) || mkdir($root, 0700)) && is_readable($root) && is_writable($root);
        }, $failure);
        if (!$ready) {
            if ($failure->details['reason'] === 'operation-failed') {
                $failure->details['reason'] = 'not-writable';
            }
            $failure->messageKey = 'temporaryStorageError';
            $failure->errorCode = 'OGDW-TEMP-' . strtoupper($failure->details['reason']);
            continue;
        }
        return $root;
    }
    throw $failure;
}

function installerWriteJson($path, $data) {
    $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    if (!is_string($json) || is_link($path)) {
        throw new InstallerFailure('filesystemError', 'OGDW-STATE-WRITE');
    }
    $stream = @fopen($path, 'c+b');
    if (!$stream) {
        throw new InstallerFailure('filesystemError', 'OGDW-STATE-OPEN');
    }
    try {
        if (!@flock($stream, LOCK_EX) || !@ftruncate($stream, 0)) {
            throw new InstallerFailure('filesystemError', 'OGDW-STATE-LOCK');
        }
        $offset = 0;
        while ($offset < strlen($json)) {
            $written = @fwrite($stream, substr($json, $offset));
            if ($written === false || $written === 0) {
                throw new InstallerFailure('filesystemError', 'OGDW-STATE-WRITE');
            }
            $offset += $written;
        }
        if (!@fflush($stream)) {
            throw new InstallerFailure('filesystemError', 'OGDW-STATE-FLUSH');
        }
    } finally {
        flock($stream, LOCK_UN);
        fclose($stream);
    }
}

function installerRemoveWork($path, $root) {
    $normalizedRoot = str_replace('\\', '/', realpath($root) ?: $root);
    $normalizedPath = str_replace('\\', '/', realpath($path) ?: $path);
    if (is_link($path) || strpos($normalizedPath, $normalizedRoot . '/') !== 0) {
        throw new InstallerFailure('filesystemError', 'OGDW-CLEANUP-BOUNDARY');
    }
    if (is_dir($path)) {
        foreach (scandir($path) as $name) {
            if ($name !== '.' && $name !== '..') {
                installerRemoveWork($path . '/' . $name, $root);
            }
        }
        rmdir($path);
    } elseif (file_exists($path)) {
        unlink($path);
    }
}

function installerLog($code, $stage, $details = []) {
    $safeDetails = [];
    foreach (['attempt', 'bytes', 'total', 'http', 'commit', 'archiveSha256', 'sourceLine'] as $key) {
        if (isset($details[$key]) && (is_int($details[$key]) || is_string($details[$key]) && preg_match('/^[a-f0-9]{40,64}$/', $details[$key]))) {
            $safeDetails[$key] = $details[$key];
        }
    }
    $allowedDetails = [
        'operation' => ['is-link', 'is-file', 'is-dir', 'file-exists', 'realpath', 'mkdir', 'fopen', 'fwrite', 'fread', 'fclose', 'flock', 'fflush', 'ftruncate', 'file-put-contents', 'file-get-contents', 'copy', 'rename', 'unlink', 'rmdir', 'scandir', 'filesize', 'chmod', 'disk-free-space', 'hash-file'],
        'area' => ['filesystem', 'temporary', 'job-lock'],
        'reason' => ['operation-failed', 'open-basedir', 'permission-denied', 'operation-not-permitted', 'read-only', 'disk-full', 'quota-exceeded', 'not-found', 'file-limit', 'not-writable', 'public-directory'],
    ];
    foreach ($allowedDetails as $key => $values) {
        if (isset($details[$key]) && in_array($details[$key], $values, true)) {
            $safeDetails[$key] = $details[$key];
        }
    }
    $entry = ['time' => gmdate('c'), 'code' => preg_match('/^OGDW-[A-Z0-9-]{2,70}$/', $code) ? $code : 'OGDW-INTERNAL', 'stage' => preg_replace('/[^a-z-]/', '', $stage), 'details' => $safeDetails];
    $path = __DIR__ . '/browser_installer.log';
    $entries = [];
    if (is_file($path) && !is_link($path) && filesize($path) < 65536) {
        $decoded = base64_decode(file_get_contents($path), true);
        $previous = is_string($decoded) ? json_decode($decoded, true) : null;
        if (is_array($previous)) {
            $entries = array_slice($previous, -39);
        }
    }
    $entries[] = $entry;
    $encoded = base64_encode(json_encode($entries, JSON_UNESCAPED_SLASHES));
    if (!is_link($path)) {
        @file_put_contents($path, $encoded, LOCK_EX);
        if (function_exists('chmod')) {
            @chmod($path, 0600);
        }
    }
    return $encoded;
}

function installerBlobHash($path, $size) {
    $context = hash_init('sha1');
    hash_update($context, 'blob ' . $size . "\0");
    $stream = fopen($path, 'rb');
    if (!$stream) {
        throw new InstallerFailure('filesystemError', 'OGDW-HASH-READ');
    }
    try {
        hash_update_stream($context, $stream);
    } finally {
        fclose($stream);
    }
    return hash_final($context);
}

function installerOpenArchive($archive, $release, $emit) {
    if (!class_exists(\ZipArchive::class)) {
        throw new InstallerFailure('dependencyError', 'OGDW-PHP-ZIP');
    }
    $sha256 = hash_file('sha256', $archive);
    if ($release['digest'] !== '' && !hash_equals($release['digest'], $sha256)) {
        throw new InstallerFailure('verificationError', 'OGDW-HASH-ARCHIVE');
    }
    $zip = new \ZipArchive;
    if ($zip->open($archive) !== true) {
        throw new InstallerFailure('archiveError', 'OGDW-ZIP-OPEN');
    }
    $indices = [];
    $seen = [];
    $prefix = null;
    try {
        if ($zip->numFiles > 40000) {
            throw new InstallerFailure('storageError', 'OGDW-ZIP-ENTRIES');
        }
        for ($index = 0; $index < $zip->numFiles; $index++) {
            $stat = $zip->statIndex($index);
            $name = is_array($stat) ? ($stat['name'] ?? '') : '';
            $slash = strpos($name, '/');
            if ($slash === false) {
                throw new InstallerFailure('verificationError', 'OGDW-ZIP-ROOT');
            }
            $root = substr($name, 0, $slash);
            if (!installerSafeRelativePath($root) || $prefix !== null && $prefix !== $root) {
                throw new InstallerFailure('verificationError', 'OGDW-ZIP-PREFIX');
            }
            $prefix = $root;
            $relative = substr($name, $slash + 1);
            $directory = substr($name, -1) === '/';
            if ($directory && $relative === '') {
                continue;
            }
            $relative = $directory ? rtrim($relative, '/') : $relative;
            $folded = strtolower($relative);
            $mode = 0;
            if ($zip->getExternalAttributesIndex($index, $system, $attributes)) {
                $mode = ($attributes >> 16) & 0170000;
            }
            if (!installerSafeRelativePath($relative) || isset($seen[$folded]) || !in_array($mode, [0, 0100000, 0040000], true) || !empty($stat['encryption_method'])) {
                throw new InstallerFailure('verificationError', 'OGDW-ZIP-UNSAFE');
            }
            $seen[$folded] = true;
            if ($directory) {
                continue;
            }
            $expected = $release['files'][$relative] ?? null;
            if (!$expected || $stat['size'] !== $expected['size']) {
                throw new InstallerFailure('verificationError', 'OGDW-HASH-FILE-SIZE');
            }
            $stream = $zip->getStream($name);
            if (!$stream) {
                throw new InstallerFailure('archiveError', 'OGDW-ZIP-READ');
            }
            $context = hash_init('sha1');
            hash_update($context, 'blob ' . $expected['size'] . "\0");
            $bytes = hash_update_stream($context, $stream, $expected['size'] + 1);
            fclose($stream);
            if ($bytes !== $expected['size'] || !hash_equals($expected['sha'], hash_final($context))) {
                throw new InstallerFailure('verificationError', 'OGDW-HASH-FILE');
            }
            $indices[$relative] = $index;
            $emit('verifying', 55 + (int) floor(count($indices) / count($release['files']) * 13));
        }
        if (count($indices) !== count($release['files'])) {
            throw new InstallerFailure('verificationError', 'OGDW-HASH-INCOMPLETE');
        }
    } catch (\Throwable $failure) {
        $zip->close();
        throw $failure;
    }
    return [$zip, $indices, $sha256];
}

function installerExtract($zip, $indices, $destination, $emit) {
    if (!mkdir($destination, 0700)) {
        throw new InstallerFailure('filesystemError', 'OGDW-EXTRACT-CREATE');
    }
    $processed = 0;
    foreach ($indices as $relative => $index) {
        $path = $destination . '/' . $relative;
        $parent = dirname($path);
        if (!is_dir($parent) && !mkdir($parent, 0700, true)) {
            throw new InstallerFailure('archiveError', 'OGDW-EXTRACT-DIRECTORY');
        }
        $stream = $zip->getStream($zip->getNameIndex($index));
        if (!$stream) {
            throw new InstallerFailure('archiveError', 'OGDW-EXTRACT-STREAM');
        }
        try {
            if (file_put_contents($path, $stream) === false) {
                throw new InstallerFailure('archiveError', 'OGDW-EXTRACT-WRITE');
            }
        } finally {
            fclose($stream);
        }
        $processed++;
        $emit('extracting', 70 + (int) floor($processed / count($indices) * 10));
    }
}

function installerPreserve($relative, $target) {
    $first = explode('/', $relative)[0];
    if (in_array($first, ['.git', '.github', 'tests', 'test', 'selfdocs', 'decompiled', 'bruh_why_i_dont_need_thatXD', 'AGENTS.md', 'incl', 'installer.php', 'browser_installer.log'], true)) {
        return true;
    }
    if (file_exists($target . '/' . $relative)) {
        if (in_array($relative, ['gdps_settings.json', 'manifest.json'], true) || $first === 'customfiles') {
            return true;
        }
        if ($first === 'assets' && !preg_match('~^assets/(?:css|js|htmlext)/~', $relative)) {
            return true;
        }
    }
    return false;
}

function installerDestination($target, $relative, &$createdDirectories) {
    $current = $target;
    foreach (explode('/', dirname($relative)) as $segment) {
        if ($segment === '.') {
            continue;
        }
        $current .= '/' . $segment;
        $resolved = realpath($current);
        $matches = $resolved === false || strcasecmp(str_replace('\\', '/', $resolved), str_replace('\\', '/', $current)) === 0;
        if (!$matches || is_link($current) || file_exists($current) && !is_dir($current)) {
            throw new InstallerFailure('pathError', 'OGDW-TARGET-SYMLINK');
        }
        if (!is_dir($current)) {
            if (!mkdir($current, 0755)) {
                throw new InstallerFailure('filesystemError', 'OGDW-TARGET-DIRECTORY');
            }
            $createdDirectories[] = $current;
        }
    }
    $path = $target . '/' . $relative;
    if (is_link($path) || file_exists($path) && !is_file($path)) {
        throw new InstallerFailure('pathError', 'OGDW-TARGET-FILE');
    }
    return $path;
}

function installerRememberFile($destination, $backup, &$journal, $jobDirectory) {
    $saved = null;
    if (is_file($destination)) {
        $saved = $backup . '/' . count($journal);
        if (!copy($destination, $saved)) {
            throw new InstallerFailure('filesystemError', 'OGDW-BACKUP-WRITE');
        }
    }
    $entry = ['destination' => $destination, 'backup' => $saved];
    $journal[] = $entry;
    if (file_put_contents($jobDirectory . '/journal.ndjson', json_encode($entry) . "\n", FILE_APPEND | LOCK_EX) === false) {
        throw new InstallerFailure('filesystemError', 'OGDW-JOURNAL-WRITE');
    }
}

function installerPublish($source, $target, $release, $jobDirectory, $emit) {
    $journal = [];
    $createdDirectories = [];
    $backup = $jobDirectory . '/backup';
    if (!is_dir($backup)) {
        mkdir($backup, 0700);
    }
    try {
        if (!is_dir($target)) {
            mkdir($target, 0755, true);
        }
        $processed = 0;
        foreach ($release['files'] as $relative => $metadata) {
            $processed++;
            if (installerPreserve($relative, $target)) {
                continue;
            }
            $destination = installerDestination($target, $relative, $createdDirectories);
            installerRememberFile($destination, $backup, $journal, $jobDirectory);
            if (!copy($source . '/' . $relative, $destination) || !hash_equals($metadata['sha'], installerBlobHash($destination, $metadata['size']))) {
                throw new InstallerFailure('filesystemError', 'OGDW-PUBLISH-WRITE');
            }
            $emit('placing', 80 + (int) floor($processed / count($release['files']) * 15));
        }
        $versionPath = installerDestination($target, 'update/version.txt', $createdDirectories);
        installerRememberFile($versionPath, $backup, $journal, $jobDirectory);
        $emit('finalizing', 96);
        if (file_put_contents($versionPath, $release['version']) === false) {
            throw new InstallerFailure('filesystemError', 'OGDW-VERSION-WRITE');
        }
    } catch (\Throwable $failure) {
        try {
            foreach (array_reverse($journal) as $entry) {
                if ($entry['backup'] !== null) {
                    if (!copy($entry['backup'], $entry['destination'])) {
                        throw new InstallerFailure('rollbackError', 'OGDW-ROLLBACK-FAILED');
                    }
                } elseif (is_file($entry['destination']) && !unlink($entry['destination'])) {
                    throw new InstallerFailure('rollbackError', 'OGDW-ROLLBACK-FAILED');
                }
            }
            foreach (array_reverse($createdDirectories) as $directory) {
                if (is_dir($directory) && count(scandir($directory)) === 2) {
                    rmdir($directory);
                }
            }
            if (is_file($jobDirectory . '/journal.ndjson')) {
                unlink($jobDirectory . '/journal.ndjson');
            }
        } catch (\Throwable $rollbackFailure) {
            throw new InstallerFailure('rollbackError', 'OGDW-ROLLBACK-FAILED');
        }
        throw $failure;
    }
}

function installerHttp($url, $destination = null, $progress = null, $head = false) {
    if (!is_callable('curl_init')) {
        throw new InstallerFailure('dependencyError', 'OGDW-PHP-CURL');
    }
    $allowedHosts = ['api.github.com', 'github.com', 'codeload.github.com', 'release-assets.githubusercontent.com', 'objects.githubusercontent.com'];
    for ($redirect = 0; $redirect < 4; $redirect++) {
        $parts = parse_url($url);
        if (!$parts || ($parts['scheme'] ?? '') !== 'https' || !in_array(strtolower($parts['host'] ?? ''), $allowedHosts, true) || isset($parts['user']) || isset($parts['pass']) || isset($parts['port']) && $parts['port'] !== 443) {
            throw new InstallerFailure('verificationError', 'OGDW-URL-REJECTED');
        }
        $headers = [];
        $body = '';
        $written = 0;
        $writeFailure = false;
        $limit = $destination ? 536870912 : 8388608;
        $file = $destination ? fopen($destination, 'wb') : null;
        if ($destination && !$file) {
            throw new InstallerFailure('filesystemError', 'OGDW-DOWNLOAD-WRITE');
        }
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_HTTPHEADER, ['User-Agent: ObeyGDBrowser-Installer', 'Accept: application/vnd.github+json']);
        curl_setopt($request, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($request, CURLOPT_TIMEOUT, $destination ? 480 : 45);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($request, CURLOPT_NOBODY, $head);
        curl_setopt($request, CURLOPT_HEADERFUNCTION, function ($request, $line) use (&$headers) {
            if (preg_match('~^HTTP/\S+\s+\d+~', $line)) {
                $headers = [];
            } elseif (strpos($line, ':') !== false) {
                list($name, $value) = explode(':', $line, 2);
                $headers[strtolower(trim($name))] = trim($value);
            }
            return strlen($line);
        });
        curl_setopt($request, CURLOPT_WRITEFUNCTION, function ($request, $chunk) use (&$body, &$written, &$writeFailure, $file, $limit, &$headers, $progress) {
            $length = strlen($chunk);
            if (isset($headers['location'])) {
                return $length;
            }
            if ($written + $length > $limit) {
                $writeFailure = true;
                return 0;
            }
            if ($file) {
                $offset = 0;
                while ($offset < $length) {
                    $count = fwrite($file, substr($chunk, $offset));
                    if ($count === false || $count === 0) {
                        $writeFailure = true;
                        return 0;
                    }
                    $offset += $count;
                }
            } else {
                $body .= $chunk;
            }
            $written += $length;
            if ($progress) {
                $progress($written, isset($headers['content-length']) ? (int) $headers['content-length'] : 0);
            }
            return $length;
        });
        try {
            $success = curl_exec($request);
            $status = (int) curl_getinfo($request, CURLINFO_HTTP_CODE);
            $curlCode = curl_errno($request);
        } finally {
            curl_close($request);
            if ($file) {
                fclose($file);
            }
        }
        if (in_array($status, [301, 302, 303, 307, 308], true) && isset($headers['location'])) {
            $url = $headers['location'];
            continue;
        }
        if (in_array($status, [403, 429], true)) {
            if (session_status() === PHP_SESSION_ACTIVE) {
                $wait = isset($headers['retry-after']) && ctype_digit($headers['retry-after']) ? (int) $headers['retry-after'] : 60;
                $_SESSION['installer']['retryAfter'] = time() + max(60, min(3600, $wait));
            }
            throw new InstallerFailure('githubRejectedError', 'OGDW-GITHUB-HTTP-' . $status, 503);
        }
        if ($curlCode === 27) {
            throw new InstallerFailure('memoryError', 'OGDW-MEMORY-DOWNLOAD');
        }
        if ($writeFailure) {
            throw new InstallerFailure('storageError', 'OGDW-DOWNLOAD-LIMIT');
        }
        if ($head && in_array($status, [405, 501], true)) {
            return ['body' => '', 'headers' => [], 'bytes' => 0];
        }
        if ($success === false || $status < 200 || $status >= 300) {
            throw new InstallerFailure('downloadError', 'OGDW-DOWNLOAD-' . ($status ? 'HTTP-' . $status : 'CURL-' . $curlCode));
        }
        return ['body' => $body, 'headers' => $headers, 'bytes' => $written];
    }
    throw new InstallerFailure('downloadError', 'OGDW-DOWNLOAD-REDIRECT');
}

function installerGithub($endpoint) {
    if (($_SESSION['installer']['retryAfter'] ?? 0) > time()) {
        throw new InstallerFailure('githubRejectedError', 'OGDW-GITHUB-WAIT', 503);
    }
    $response = installerHttp('https://api.github.com/repos/MigMatos/ObeyGDBrowser/' . $endpoint);
    $data = json_decode($response['body'], true);
    if (!is_array($data)) {
        throw new InstallerFailure('releaseError', 'OGDW-GITHUB-JSON');
    }
    return $data;
}

function installerRelease($branch) {
    if (!in_array($branch, ['stable', 'prerelease', 'master'], true)) {
        throw new InstallerFailure('requestError', 'OGDW-BRANCH-INVALID', 400);
    }
    $cached = $_SESSION['installer']['releases'][$branch] ?? null;
    if (is_array($cached) && ($cached['created'] ?? 0) > time() - 600) {
        return $cached;
    }
    $release = null;
    if ($branch === 'stable') {
        try {
            $release = installerGithub('releases/latest');
        } catch (InstallerFailure $failure) {
            if ($failure->errorCode === 'OGDW-DOWNLOAD-HTTP-404') {
                throw new InstallerFailure('noReleaseError', 'OGDW-RELEASE-NOT-FOUND', 404);
            }
            throw $failure;
        }
    } elseif ($branch === 'prerelease') {
        foreach (installerGithub('releases?per_page=20') as $candidate) {
            if (is_array($candidate) && !empty($candidate['prerelease']) && empty($candidate['draft'])) {
                $release = $candidate;
                break;
            }
        }
        if (!$release) {
            throw new InstallerFailure('noReleaseError', 'OGDW-RELEASE-NOT-FOUND', 404);
        }
    }
    $reference = $branch === 'master' ? 'main' : ($release['tag_name'] ?? '');
    if (!is_string($reference) || strlen($reference) > 128 || !preg_match('~^[A-Za-z0-9._/-]+$~', $reference)) {
        throw new InstallerFailure('releaseError', 'OGDW-RELEASE-REFERENCE');
    }
    $commit = installerGithub('commits/' . rawurlencode($reference));
    $commitHash = $commit['sha'] ?? '';
    $treeHash = $commit['commit']['tree']['sha'] ?? '';
    if (!is_string($commitHash) || !is_string($treeHash) || !preg_match('/^[a-f0-9]{40}$/', $commitHash) || !preg_match('/^[a-f0-9]{40}$/', $treeHash)) {
        throw new InstallerFailure('verificationError', 'OGDW-COMMIT-INVALID');
    }
    $tree = installerGithub('git/trees/' . $treeHash . '?recursive=1');
    if (($tree['sha'] ?? '') !== $treeHash || !empty($tree['truncated']) || !isset($tree['tree']) || !is_array($tree['tree']) || count($tree['tree']) > 20000) {
        throw new InstallerFailure('verificationError', 'OGDW-TREE-INCOMPLETE');
    }
    $files = [];
    $totalBytes = 0;
    foreach ($tree['tree'] as $entry) {
        if (($entry['type'] ?? '') === 'tree') {
            continue;
        }
        $path = $entry['path'] ?? '';
        $size = $entry['size'] ?? -1;
        if (($entry['type'] ?? '') !== 'blob' || !in_array($entry['mode'] ?? '', ['100644', '100755'], true) || !installerSafeRelativePath($path) || !is_int($size) || $size < 0 || $size > 134217728 || !preg_match('/^[a-f0-9]{40}$/', $entry['sha'] ?? '')) {
            throw new InstallerFailure('verificationError', 'OGDW-TREE-UNSAFE');
        }
        $files[$path] = ['size' => $size, 'sha' => $entry['sha']];
        $totalBytes += $size;
        if ($totalBytes > 1610612736) {
            throw new InstallerFailure('storageError', 'OGDW-UNPACKED-LIMIT');
        }
    }
    if (!isset($files['index.php'], $files['_init_.php'], $files['assets/css/browser.css'])) {
        throw new InstallerFailure('verificationError', 'OGDW-BROWSER-CONTENT');
    }
    $archiveUrl = 'https://codeload.github.com/MigMatos/ObeyGDBrowser/zip/' . $commitHash;
    $digest = '';
    $downloadBytes = 0;
    foreach ($release['assets'] ?? [] as $asset) {
        if (is_array($asset) && preg_match('/^(?:ObeyGDBrowser|ogdbrowser_sourcecode)[A-Za-z0-9._-]*\.zip$/i', $asset['name'] ?? '') && preg_match('/^sha256:[a-f0-9]{64}$/', $asset['digest'] ?? '') && is_int($asset['size'] ?? null) && $asset['size'] > 0 && $asset['size'] <= 536870912 && preg_match('~^https://github\.com/MigMatos/ObeyGDBrowser/releases/download/[^?#]+$~i', $asset['browser_download_url'] ?? '')) {
            $archiveUrl = $asset['browser_download_url'];
            $digest = substr($asset['digest'], 7);
            $downloadBytes = $asset['size'];
            break;
        }
    }
    if (!$downloadBytes) {
        $head = installerHttp($archiveUrl, null, null, true);
        $length = $head['headers']['content-length'] ?? '';
        if (ctype_digit($length) && (float) $length > 0 && (float) $length <= 536870912) {
            $downloadBytes = (int) $length;
        }
    }
    $changes = $release['body'] ?? $commit['commit']['message'] ?? '';
    $changes = is_string($changes) ? substr($changes, 0, 20000) : '';
    while (!preg_match('//u', $changes)) {
        $changes = substr($changes, 0, -1);
    }
    $result = [
        'created' => time(), 'branch' => $branch,
        'version' => $branch === 'master' ? substr($commitHash, 0, 7) . '-MAIN' : $reference,
        'changes' => $changes,
        'commit' => $commitHash, 'files' => $files, 'unpackedBytes' => $totalBytes,
        'url' => $archiveUrl, 'digest' => $digest, 'downloadBytes' => $downloadBytes,
        'downloadLimit' => $downloadBytes ?: min(536870912, (int) ceil($totalBytes * 1.02) + count($files) * 1024 + 1048576),
    ];
    $_SESSION['installer']['releases'][$branch] = $result;
    return $result;
}

function installerSession() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_name('ogdwInstaller');
        session_set_cookie_params([
            'lifetime' => 0, 'path' => rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/') . '/',
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true, 'samesite' => 'Strict',
        ]);
        if (!session_start(['use_strict_mode' => 1])) {
            throw new InstallerFailure('serverError', 'OGDW-SESSION-START');
        }
    }
    if (!isset($_SESSION['installer']) || !is_array($_SESSION['installer'])) {
        $_SESSION['installer'] = ['csrf' => bin2hex(random_bytes(32))];
    }
}

function installerHasOwner() {
    return isset($_SESSION['installer']['owner'], $_SESSION['installer']['authenticatedAt']) && $_SESSION['installer']['authenticatedAt'] > time() - 1800;
}

function installerAuthenticate($connectionFolder, &$stage) {
    $base = $connectionFolder;
    if (strpos($base, "\0") !== false || strpos($base, '://') !== false) {
        throw new InstallerFailure('connectionError', 'OGDW-CONNECTION-PATH', 400);
    }
    if (!preg_match('~^(?:[A-Za-z]:[/\\\\]|/)~', $base)) {
        $base = __DIR__ . '/' . $base;
    }
    $base = realpath($base);
    if (!$base || !is_file($base . '/connection.php') || !is_file($base . '/generatePass.php')) {
        throw new InstallerFailure('connectionError', 'OGDW-CONNECTION-FOLDER', 400);
    }
    $stage = 'connection';
    require $base . '/connection.php';
    if (!isset($db) || !is_object($db) || !is_callable([$db, 'prepare'])) {
        throw new InstallerFailure('databaseConnectionError', 'OGDW-SQL-CONNECTION');
    }
    require_once $base . '/generatePass.php';
    if (!is_callable([GeneratePass::class, 'isValidUsrname'])) {
        throw new InstallerFailure('dependencyError', 'OGDW-PHP-AUTH');
    }
    $userName = $_POST['userName'] ?? null;
    $password = $_POST['password'] ?? null;
    if (!is_string($userName) || !is_string($password) || trim($userName) === '' || trim($password) === '' || strlen($userName) > 64 || strlen($password) > 4096) {
        throw new InstallerFailure('credentialsError', 'OGDW-AUTH-INPUT', 400);
    }
    $stage = 'authentication';
    $result = GeneratePass::isValidUsrname($userName, $password);
    if (is_bool($result)) {
        $result = (int) $result;
    }
    $failures = ['0' => 'credentialsError', '-1' => 'rateLimitError', '-2' => 'inactiveAccountError'];
    if (!in_array($result, [1, '1'], true)) {
        $key = is_int($result) || is_string($result) ? ($failures[(string) $result] ?? 'authenticationError') : 'authenticationError';
        throw new InstallerFailure($key, 'OGDW-AUTH-FAILED', $key === 'authenticationError' ? 500 : 403);
    }
    $stage = 'account';
    $statement = $db->prepare('SELECT accountID, isAdmin FROM accounts WHERE userName = :userName');
    if (!$statement || !$statement->execute([':userName' => $userName])) {
        throw new InstallerFailure('databaseQueryError', 'OGDW-SQL-ACCOUNT');
    }
    $account = $statement->fetch(\PDO::FETCH_ASSOC);
    if (!$account || (string) ($account['isAdmin'] ?? '') !== '1' || !isset($account['accountID'])) {
        throw new InstallerFailure('ownerError', 'OGDW-AUTH-OWNER', 403);
    }
    return (int) $account['accountID'];
}

function installerPublicPlan($plan) {
    return [
        'id' => $plan['id'], 'branch' => $plan['release']['branch'], 'version' => $plan['release']['version'],
        'changes' => $plan['release']['changes'], 'commit' => $plan['release']['commit'],
        'downloadBytes' => $plan['release']['downloadBytes'], 'downloadLimit' => $plan['release']['downloadLimit'],
        'unpackedBytes' => $plan['release']['unpackedBytes'], 'digest' => $plan['release']['digest'] !== '',
        'target' => $plan['target']['relative'], 'repair' => $plan['target']['repair'], 'manual' => $plan['manual'],
    ];
}

function installerJobState($job) {
    if (!is_array($job) || !preg_match('/^[a-f0-9]{32}$/', $job['id'] ?? '')) {
        return null;
    }
    $path = installerWorkRoot() . '/' . $job['id'] . '/state.json';
    if (!is_file($path) || is_link($path) || filesize($path) > 131072) {
        return null;
    }
    $stream = fopen($path, 'rb');
    if (!$stream) {
        return null;
    }
    try {
        if (!flock($stream, LOCK_SH)) {
            return null;
        }
        $json = stream_get_contents($stream, 131073);
    } finally {
        flock($stream, LOCK_UN);
        fclose($stream);
    }
    $data = is_string($json) && strlen($json) <= 131072 ? json_decode($json, true) : null;
    return is_array($data) ? $data : null;
}

function installerExecute($plan, $jobDirectory, $emit) {
    $release = $plan['release'];
    if (!class_exists(\ZipArchive::class)) {
        throw new InstallerFailure('dependencyError', 'OGDW-PHP-ZIP');
    }
    $free = disk_free_space(__DIR__);
    $needed = $release['downloadLimit'] + $release['unpackedBytes'] * 3 + 16777216;
    foreach ($release['files'] as $relative => $metadata) {
        $existing = $plan['target']['path'] . '/' . $relative;
        if (!installerPreserve($relative, $plan['target']['path']) && is_file($existing)) {
            $needed += filesize($existing);
        }
    }
    if ($free === false || $free < $needed) {
        throw new InstallerFailure('storageError', 'OGDW-DISK-SPACE');
    }
    $emit('downloading', 2);
    $archive = $jobDirectory . '/download.zip';
    $response = installerHttp($release['url'], $archive, function ($bytes, $reportedTotal) use ($release, $emit) {
        $total = $release['downloadBytes'] ?: $reportedTotal;
        $denominator = $total ?: $release['downloadLimit'];
        if ($bytes > $release['downloadLimit']) {
            throw new InstallerFailure('storageError', 'OGDW-DOWNLOAD-SIZE');
        }
        $emit('downloading', min(52, 2 + (int) floor($bytes / max(1, $denominator) * 50)), ['bytes' => $bytes, 'total' => $total]);
    });
    if ($response['bytes'] <= 0 || $release['downloadBytes'] && $response['bytes'] !== $release['downloadBytes']) {
        throw new InstallerFailure('downloadError', 'OGDW-DOWNLOAD-INCOMPLETE');
    }
    $emit('verifying', 55);
    list($zip, $indices, $archiveHash) = installerOpenArchive($archive, $release, $emit);
    installerLog('OGDW-ARCHIVE-VERIFIED', 'verifying', ['bytes' => $response['bytes'], 'commit' => $release['commit'], 'archiveSha256' => $archiveHash]);
    try {
        for ($attempt = 1; $attempt <= 2; $attempt++) {
            $source = $jobDirectory . '/source';
            if (is_dir($source)) {
                installerRemoveWork($source, $jobDirectory);
            }
            try {
                $emit($attempt === 1 ? 'extracting' : 'retrying', 70, ['attempt' => $attempt]);
                installerExtract($zip, $indices, $source, $emit);
                installerTarget($plan['target']['relative'], $plan['allowCustom']);
                $emit('placing', 80, ['attempt' => $attempt]);
                installerPublish($source, $plan['target']['path'], $release, $jobDirectory, $emit);
                break;
            } catch (\Throwable $failure) {
                if ($failure instanceof InstallerFailure && in_array($failure->messageKey, ['verificationError', 'pathError', 'rollbackError'], true)) {
                    throw $failure;
                }
                installerLog('OGDW-PLACE-ATTEMPT-' . $attempt, 'placing', ['attempt' => $attempt]);
                $details = $failure instanceof InstallerFailure ? $failure->details : [];
                installerLog($failure instanceof InstallerFailure ? $failure->errorCode : 'OGDW-PHP-PLACEMENT', 'placing', array_merge($details, ['attempt' => $attempt]));
                if ($attempt === 2) {
                    throw new InstallerFailure('placementError', 'OGDW-PLACE-FAILED-TWICE', 500, $details);
                }
            }
        }
    } finally {
        $zip->close();
    }
    $emit('finalizing', 98);
}

function installerAction($action, &$stage, &$view, &$activeJob, $beginStream, $emit) {
    if (!is_string($_POST['csrf'] ?? null) || !hash_equals($_SESSION['installer']['csrf'], $_POST['csrf'])) {
        throw new InstallerFailure('sessionError', 'OGDW-CSRF', 403);
    }
    if ($action === 'login') {
        if (isset($_SESSION['installer']['job'])) {
            throw new InstallerFailure('lockedError', 'OGDW-ACCEPTED', 409);
        }
        $defaultConnection = is_file(__DIR__ . '/incl/lib/connection.php') && is_file(__DIR__ . '/incl/lib/generatePass.php');
        $folder = $defaultConnection ? './incl/lib/' : ($_POST['conn'] ?? '../incl/lib/');
        if (!is_string($folder)) {
            throw new InstallerFailure('connectionError', 'OGDW-CONNECTION-INPUT', 400);
        }
        $stage = 'authentication';
        $owner = installerAuthenticate($folder, $stage);
        session_regenerate_id(true);
        $_SESSION['installer']['owner'] = $owner;
        $_SESSION['installer']['authenticatedAt'] = time();
        $_SESSION['installer']['allowCustom'] = !$defaultConnection;
        return ['ok' => true, 'step' => 'selection', 'allowCustom' => !$defaultConnection, 'repair' => installerIsBrowser(__DIR__) || is_dir(__DIR__ . '/browser')];
    }
    if (!installerHasOwner()) {
        throw new InstallerFailure('sessionError', 'OGDW-SESSION-EXPIRED', 401);
    }
    if ($action === 'logs') {
        $path = __DIR__ . '/browser_installer.log';
        return ['ok' => true, 'log' => is_file($path) && !is_link($path) && filesize($path) < 65536 ? file_get_contents($path) : ''];
    }
    if ($action === 'status') {
        return ['ok' => true, 'job' => installerJobState($_SESSION['installer']['job'] ?? null)];
    }
    if (isset($_SESSION['installer']['job'])) {
        throw new InstallerFailure('lockedError', 'OGDW-ACCEPTED', 409);
    }
    if ($action === 'plan') {
        $stage = 'release';
        $allowCustom = !empty($_SESSION['installer']['allowCustom']);
        $custom = ($_POST['customPath'] ?? '') === '1';
        if ($custom && !$allowCustom) {
            throw new InstallerFailure('pathError', 'OGDW-PATH-DISABLED', 400);
        }
        $relative = $custom ? ($_POST['target'] ?? '') : (installerIsBrowser(__DIR__) ? '.' : 'browser');
        $target = installerTarget($relative, $allowCustom && $custom);
        $branch = $_POST['branch'] ?? '';
        if (!is_string($branch)) {
            throw new InstallerFailure('requestError', 'OGDW-BRANCH-INPUT', 400);
        }
        $release = installerRelease($branch);
        $plan = [
            'id' => bin2hex(random_bytes(24)), 'created' => time(), 'release' => $release,
            'target' => $target, 'manual' => $custom, 'allowCustom' => $allowCustom && $custom,
        ];
        $_SESSION['installer']['plan'] = $plan;
        return ['ok' => true, 'plan' => installerPublicPlan($plan)];
    }
    if ($action !== 'start') {
        throw new InstallerFailure('requestError', 'OGDW-ACTION', 400);
    }
    $plan = $_SESSION['installer']['plan'] ?? null;
    if (!is_array($plan) || !is_string($_POST['plan'] ?? null) || !hash_equals($plan['id'], $_POST['plan']) || $plan['created'] < time() - 900 || ($_POST['confirm'] ?? '') !== '1') {
        throw new InstallerFailure('confirmationError', 'OGDW-CONFIRMATION', 409);
    }
    $stage = 'files';
    $root = installerWorkRoot();
    $lockFailure = null;
    $lock = installerFilesystemAttempt('fopen', 'job-lock', function () use ($root) {
        return fopen($root . '/installer.lock', 'c+b');
    }, $lockFailure);
    if (!$lock) {
        throw $lockFailure;
    }
    if (!flock($lock, LOCK_EX | LOCK_NB)) {
        throw new InstallerFailure('lockedError', 'OGDW-INSTALL-BUSY', 409);
    }
    $jobId = bin2hex(random_bytes(16));
    $directory = $root . '/' . $jobId;
    if (!mkdir($directory, 0700)) {
        throw new InstallerFailure('filesystemError', 'OGDW-JOB-CREATE');
    }
    $activeJob = ['id' => $jobId, 'directory' => $directory, 'lock' => $lock, 'plan' => $plan];
    $emit('preparing', 0);
    $_SESSION['installer']['job'] = ['id' => $jobId];
    unset($_SESSION['installer']['plan']);
    session_write_close();
    if (function_exists('ignore_user_abort')) {
        ignore_user_abort(true);
    }
    if (function_exists('set_time_limit')) {
        set_time_limit(600);
    }
    $beginStream();
    $stage = 'download';
    installerExecute($plan, $directory, $emit);
    $stage = 'files';
    $emit('finalizing', 99);
    foreach (['source', 'backup', 'download.zip', 'journal.ndjson'] as $name) {
        if (file_exists($directory . '/' . $name)) {
            installerRemoveWork($directory . '/' . $name, $directory);
        }
    }
    if (is_file(__DIR__ . '/browser_installer.log') && !unlink(__DIR__ . '/browser_installer.log')) {
        throw new InstallerFailure('filesystemError', 'OGDW-LOG-CLEANUP');
    }
    if (!unlink(__FILE__)) {
        throw new InstallerFailure('filesystemError', 'OGDW-INSTALLER-CLEANUP');
    }
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    $suffix = $plan['target']['relative'] === '.' ? '' : '/' . implode('/', array_map('rawurlencode', explode('/', $plan['target']['relative'])));
    $emit('complete', 100, ['url' => ($base . $suffix ?: '') . '/index.php', 'manual' => $plan['manual']]);
    flock($lock, LOCK_UN);
    fclose($lock);
    return ['ok' => true];
}

function runInstaller($translations, $language) {
    $initialBufferLevel = ob_get_level();
    $installerRendering = false;
    $installerFinished = false;
    $streaming = false;
    $activeJob = null;
    $lastEvent = null;
    $lastEmission = 0;
    $stage = 'connection';
    $reservedMemory = str_repeat(' ', 1048576);
    $action = $_POST['action'] ?? '';
    $expectsJson = ($_POST['api'] ?? '') === '1' || in_array($action, ['start', 'status', 'logs'], true);
    $hasDefaultConnection = is_file(__DIR__ . '/incl/lib/connection.php') && is_file(__DIR__ . '/incl/lib/generatePass.php');
    $view = [
        'alert' => 0, 'connectionFolder' => $hasDefaultConnection ? './incl/lib/' : '../incl/lib/',
        'connectionExists' => $hasDefaultConnection, 'hasCustomConnection' => false, 'blocked' => false,
        'csrf' => '', 'authenticated' => false, 'allowCustom' => false, 'repair' => false,
        'plan' => null, 'job' => null, 'code' => '', 'log' => '',
    ];
    ob_start(function ($output) use (&$installerRendering) {
        return $installerRendering ? $output : '';
    });
    $clearBuffers = function () use ($initialBufferLevel) {
        while (ob_get_level() > $initialBufferLevel) {
            ob_end_clean();
        }
    };
    $beginStream = function () use (&$streaming, &$installerRendering, $clearBuffers) {
        $clearBuffers();
        $installerRendering = true;
        $streaming = true;
        header('Content-Type: application/x-ndjson; charset=UTF-8');
        header('Cache-Control: no-store');
        header('X-Accel-Buffering: no');
    };
    $emit = function ($eventStage, $percentage, $details = []) use (&$activeJob, &$lastEvent, &$lastEmission, &$stage, &$streaming) {
        $stage = in_array($eventStage, ['extracting', 'placing', 'retrying', 'finalizing'], true) ? 'files' : $eventStage;
        $percentage = max(0, min(100, (int) $percentage));
        if ($lastEvent) {
            $percentage = max($percentage, $lastEvent['percent']);
        }
        if ($lastEvent && $lastEvent['stage'] === $eventStage && $lastEvent['percent'] === $percentage && microtime(true) - $lastEmission < 0.4) {
            return;
        }
        $event = array_merge(['stage' => $eventStage, 'percent' => $percentage, 'status' => $eventStage === 'complete' ? 'complete' : 'running'], $details);
        $lastEvent = $event;
        $lastEmission = microtime(true);
        if ($activeJob) {
            installerWriteJson($activeJob['directory'] . '/state.json', $event);
        }
        if ($streaming) {
            echo json_encode($event, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) . "\n";
            flush();
        }
    };
    $showFailure = function ($failure) use ($translations, $language, &$view, &$installerFinished, &$installerRendering, &$reservedMemory, &$stage, &$activeJob, &$streaming, $expectsJson, $clearBuffers) {
        $reservedMemory = null;
        $installerFinished = true;
        $key = is_string($failure) ? $failure : installerFailureKey($failure, $stage);
        $code = $failure instanceof InstallerFailure ? $failure->errorCode : 'OGDW-PHP-' . strtoupper(preg_replace('/([a-z])([A-Z])/', '$1-$2', $key));
        $status = $failure instanceof InstallerFailure ? $failure->httpStatus : 500;
        $view['alert'] = array_search($key, installerAlertKeys(), true) ?: 14;
        $view['blocked'] = $status >= 500 || $activeJob !== null;
        $view['code'] = $code;
        $view['log'] = '';
        try {
            $log = installerLog($code, $stage, $failure instanceof InstallerFailure ? $failure->details : []);
            if (installerHasOwner() || $activeJob) {
                $view['log'] = $log;
            }
        } catch (\Throwable $loggingFailure) {
        }
        $payload = ['ok' => false, 'status' => 'error', 'messageKey' => $key, 'code' => $code, 'blocked' => $view['blocked'], 'log' => $view['log']];
        if ($activeJob) {
            try {
                installerWriteJson($activeJob['directory'] . '/state.json', $payload);
                if ($key !== 'rollbackError' && !is_file($activeJob['directory'] . '/journal.ndjson')) {
                    foreach (['source', 'backup', 'download.zip'] as $name) {
                        if (file_exists($activeJob['directory'] . '/' . $name)) {
                            installerRemoveWork($activeJob['directory'] . '/' . $name, $activeJob['directory']);
                        }
                    }
                }
            } catch (\Throwable $cleanupFailure) {
            }
        }
        if ($streaming) {
            echo json_encode($payload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . "\n";
            flush();
            return;
        }
        $clearBuffers();
        if (!headers_sent()) {
            header_remove('Location');
            http_response_code($status);
            header('Content-Type: ' . ($expectsJson ? 'application/json' : 'text/html') . '; charset=UTF-8');
            header('Cache-Control: no-store');
        }
        $installerRendering = true;
        if ($expectsJson) {
            echo json_encode($payload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        } else {
            renderInstallerPage($translations, $language, $view);
        }
    };
    set_error_handler(function ($severity, $message, $file, $line) {
        if (!(error_reporting() & $severity) || in_array($severity, [E_DEPRECATED, E_USER_DEPRECATED, E_STRICT], true)) {
            return true;
        }
        $filesystemFailure = installerFilesystemFailure($message);
        if ($filesystemFailure) {
            $filesystemFailure->details['sourceLine'] = $line;
            throw $filesystemFailure;
        }
        throw new \ErrorException($message, 0, $severity, $file, $line);
    });
    set_exception_handler($showFailure);
    register_shutdown_function(function () use (&$installerFinished, &$stage, $showFailure) {
        if (!$installerFinished) {
            $lastError = error_get_last();
            $key = $stage === 'connection' ? 'databaseConnectionError' : 'serverError';
            if ($lastError && strpos($lastError['message'], 'Allowed memory size') !== false) {
                $key = 'memoryError';
            } elseif ($lastError && in_array($lastError['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
                $key = 'serverError';
            }
            $showFailure($key);
        }
    });
    try {
        if (function_exists('ini_set')) {
            ini_set('display_errors', '0');
            ini_set('display_startup_errors', '0');
        }
        error_reporting(E_ALL);
        $stage = 'session';
        installerSession();
        $view['csrf'] = $_SESSION['installer']['csrf'];
        $view['authenticated'] = installerHasOwner();
        $view['allowCustom'] = !empty($_SESSION['installer']['allowCustom']);
        $view['repair'] = $view['authenticated'] && (installerIsBrowser(__DIR__) || is_dir(__DIR__ . '/browser'));
        $view['job'] = $view['authenticated'] ? installerJobState($_SESSION['installer']['job'] ?? null) : null;
        if (is_array($view['job']) && ($view['job']['status'] ?? '') === 'error') {
            $view['alert'] = array_search($view['job']['messageKey'] ?? 'serverError', installerAlertKeys(), true) ?: 14;
            $view['code'] = $view['job']['code'] ?? 'OGDW-JOB-FAILED';
            $view['log'] = $view['job']['log'] ?? '';
            $view['blocked'] = true;
        }
        if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'HEAD', 'POST'], true)) {
            throw new InstallerFailure('requestError', 'OGDW-METHOD', 405);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_string($action) || !in_array($action, ['login', 'plan', 'start', 'status', 'logs'], true)) {
                throw new InstallerFailure('requestError', 'OGDW-ACTION', 400);
            }
            $result = installerAction($action, $stage, $view, $activeJob, $beginStream, $emit);
            if ($streaming) {
                $installerFinished = true;
                return;
            }
            if ($expectsJson) {
                $clearBuffers();
                $installerRendering = true;
                header('Content-Type: application/json; charset=UTF-8');
                header('Cache-Control: no-store');
                echo json_encode($result, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                $installerFinished = true;
                return;
            }
            $view['authenticated'] = installerHasOwner();
            $view['allowCustom'] = !empty($_SESSION['installer']['allowCustom']);
            $view['repair'] = installerIsBrowser(__DIR__) || is_dir(__DIR__ . '/browser');
            $view['plan'] = isset($result['plan']) ? $result['plan'] : null;
        }
        $clearBuffers();
        $installerRendering = true;
        header('Cache-Control: no-store');
        renderInstallerPage($translations, $language, $view);
        $installerFinished = true;
    } catch (\Throwable $failure) {
        $showFailure($failure);
    }
}


function renderInstallerPage($translations, $language, $view) {
    $messages = $translations[$language];
    $escape = function ($value) {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    };
    $errorKey = installerAlertKeys()[$view['alert']] ?? '';
    $titleKey = $view['authenticated'] && $view['repair'] ? 'repairTitle' : 'title';
    $installerState = [
        'translations' => $translations, 'alert' => $view['alert'], 'alertKeys' => installerAlertKeys(),
        'blocked' => $view['blocked'], 'csrf' => $view['csrf'], 'authenticated' => $view['authenticated'],
        'allowCustom' => $view['allowCustom'], 'repair' => $view['repair'], 'plan' => $view['plan'], 'job' => $view['job'],
    ];
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ObeyGDBrowser Installer</title>
    <style>@font-face{font-family:Pusab;src:url('data:font/ttf;base64,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ACr/2wAy/9wANP/cADf/fgA4/9gAOf92ADr/vgA8/1kARv/oAEr/6ABS/+kAVP/pAFf/lgBY/+cAWf+VAFr/zABc/3sAhv/kAIf/3ACQ/8kAkv/cAJP/3ACU/9wAlf/cAJb/3ACY/90Amf/YAJr/2ACb/9gAnP/YAJ3/WQCm/+YAp//oALD/2gCy/94As//fALT/4AC1/+AAtv/gALj/5AC5/9kAuv/aALv/2wC8/9sAvf9wAL//bgDD/9wAxP/pAMb/7ADH/1kAEgAt/+sAN//qADn/6gA7/+MAPP/aAEwAFABN/+oAhv/UAJD/6wCd/9oAoP/qAKH/6wCi/+wApf/rAKb/0gC9/+oAv//oAMf/2gAjACT/1QAt/78AN//ZADn/2wA6/+kAO//LADz/xgA9/+YARP/VAE3/vQBb/+oAXP/jAID/0QCB/9EAgv/RAIP/0QCE/9EAhf/RAIb/rQCQ/+AAnf/CAKD/zACh/80Aov/OAKP/zwCk/88Apf/NAKb/qgC9/9kAv//YAMH/yADC/8gAxv/QAMf/wgDI/+IAIwAk/9EALf+1ADf/zgA5/9UAOv/rADv/vAA8/7kAPf/iAET/0wBN/7cAW//jAFz/3ACA/9EAgf/RAIL/0QCD/9EAhP/RAIX/0QCG/6gAnf+5AKD/ygCh/8sAov/MAKP/zACk/8wApf/LAKb/pgC9/9IAv//QAMH/wQDC/8wAxv/fAMf/uQDI/+IAyf/sABUAJv/mACr/5QAy/+UANP/mAIb/5gCH/+YAkP/XAJL/5QCT/+UAlP/lAJX/5QCW/+UAmP/mAKb/5ACw/9YAsv/oALP/6gC0/+oAtf/rALb/6wDD/+UAQAAk/5MAJv/bACr/2gAt/50AMP/YADL/2gA0/9oANv/oADz/6QBE/48ARv/NAEr/zQBN/6QAUP/OAFL/zQBU/80AVv/WAFf/6wBc/+wAgP+TAIH/kwCC/5MAg/+TAIT/kwCF/5MAhv9YAIf/2wCQ/8sAkv/aAJP/2gCU/9oAlf/aAJb/2gCY/9sAnf/pAJ//6ACg/4sAof+MAKL/jACj/40ApP+NAKX/jACm/1EAp//NALD/ygCy/8gAs//JALT/ygC1/8oAtv/KALj/ywC5/+kAuv/rALv/6wC8/+wAvf/oAL//6ADB/60Awv+wAMP/2gDE/80Axf/oAMb/sgDH/+kABwA3/+MAOf/lADz/zwCd/8wAvf/jAL//4gDH/8wAKgAlABgAJwAZACgAGQApABgAKwAZACwAGQAuABkALwAYADEAGQAzABgANQAYAEUAGQBHABoASAAZAEkAGQBLABoATAAaAE4AGgBPABgAUAAVAFEAGQBTABkAVQAZAFgAFgCIABkAiQAZAIoAGQCLABkAjAAZAI0AGQCOABkAjwAZAJEAGQCeABoAqwAUAKwAFgCtABcArgAYAK8AGAC+ABoA5gAZAOcAGQAmACUAFgAnABcAKAAXACkAFwArABcALAAXAC4AFwAvABcAMQAXADMAFwA1ABcARQAWAEcAFwBIABYASQAXAEsAGABMABgATgAXAE8AGABRABcAUwAXAFUAFwCIABcAiQAXAIoAFwCLABcAjAAXAI0AFwCOABcAjwAXAJEAFwCeABkArQAVAK4AFgCvABYAvgAYAOYAFwDnABcAFQAk/84ALf+xAET/zABN/7gAgP/OAIH/zgCC/84Ag//OAIT/zgCF/84Ahv+jAKD/xgCh/8gAov/IAKP/yQCk/8kApf/HAKb/ngDB/78Awv/KAMb/4QAwACb/3gAq/90AMv/eADT/3gA3/+UAOP/rADn/6gA8/+cARv/pAEr/6QBS/+oAVP/pAFf/1gBY/+YAWf/aAFr/3gBc/9wAh//eAJD/xgCS/94Ak//eAJT/3gCV/94Alv/eAJj/3wCZ/+sAmv/rAJv/6wCc/+sAnf/nAKb/7ACn/+kAsP/QALL/4gCz/+MAtP/kALX/5AC2/+QAuP/nALn/3AC6/90Au//eALz/3gC9/9UAv//XAMP/3gDE/+oAx//nAEUAJP/nACb/0QAq/9AALf/qADL/0QA0/9EAN/91ADj/zAA5/1sAOv+3ADv/4wA8/1AARP/qAEb/3gBK/90AUv/fAFT/3gBX/4oAWP/bAFn/egBa/8MAW//kAFz/aACA/+cAgf/nAIL/5wCD/+cAhP/nAIX/5wCG/9QAh//RAJD/tACS/9EAk//RAJT/0QCV/9EAlv/RAJj/0gCZ/8wAmv/MAJv/zACc/8wAnf9QAKD/4gCh/+QAov/kAKP/5QCk/+UApf/jAKb/1ACn/94AsP+/ALL/1gCz/9cAtP/YALX/2AC2/9gAuP/bALn/0AC6/9EAu//SALz/0gC9/2AAv/9YAMH/5gDD/9EAxP/fAMb/4gDH/1AADAA3/80AOf/NADr/2QA8/8AAV//dAFn/3QBa/+QAXP/WAJ3/wAC9/80Av//LAMf/wAAtACUAGQAnABoAKAAaACkAGQArABoALAAaAC4AGgAvABkAMAAUADEAGQAzABkANQAZAEUAGQBHABoASAAaAEkAGgBLABsATAAbAE4AGwBPABkAUAAVAFEAGgBTABoAVQAaAFgAFgCIABoAiQAaAIoAGgCLABoAjAAaAI0AGgCOABoAjwAaAJEAGQCeABsAqgAVAKsAFQCsABcArQAYAK4AGQCvABkAsQAVAL4AGwDmABoA5wAaACEAJP/VAC3/vgA3/9YAOf/aADv/xwA8/8IAPf/mAET/1wBN/74AW//pAFz/4QCA/9EAgf/RAIL/0QCD/9EAhP/RAIX/0QCG/60Anf++AKD/zACh/80Aov/OAKP/zwCk/88Apf/NAKb/rAC9/9YAv//VAMH/yQDC/84Axv/gAMf/vgDI/+MALQAk/5sALf+aADD/5gA3/98AOf/fADr/6AA7/9YAPP/OAD3/6gBE/5cATf+mAFD/4wBX/+sAWf/sAFz/5QCA/5sAgf+bAIL/mwCD/5sAhP+bAIX/mwCG/1AAkP/qAJ3/zgCg/5IAof+TAKL/kwCj/5QApP+UAKX/kgCm/0kAsP/dALL/5gCz/+cAtP/nALX/6AC2/+gAuP/pAL3/3wC//94Awf+tAML/twDG/84Ax//OAMj/6gAlACT/2AAt/9EAN//YADn/3AA7/9MAPP/EAD3/6QBE/9kARwAUAEsAFQBMABUATf/WAE4AFQBb/+sAXP/kAID/1ACB/9QAgv/UAIP/1ACE/9QAhf/UAIb/wACd/8EAoP/PAKH/0ACi/9EAo//RAKT/0QCl/9AApv/CAL3/2QC//9gAwf/LAML/0ADG/+EAx//BAMj/5QAIADf/5wA5/+cAPP/WAJ3/1gCw/+gAvf/nAL//5gDH/9YAFQAk/+MALf/dAET/5ABN/9sAgP/fAIH/3wCC/98Ag//fAIT/3wCF/98Ahv/GAKD/3ACh/90Aov/eAKP/3gCk/94Apf/dAKb/wgDB/+IAwv/jAMb/4gBJACT/ZgAm/9UAKv/VAC3/mwAw/9QAMv/UADT/1QA2/+QAN//sADz/6gBE/1oARv+4AEr/uABN/6AAT//pAFD/yABR/+sAUv+4AFT/uABW/84AV//mAFj/6wBZ/+kAXP/pAID/ZgCB/2YAgv9mAIP/ZgCE/2YAhf9mAIb/SQCH/9UAkP+4AJL/1ACT/9QAlP/UAJX/1ACW/9QAmP/VAJ3/6gCf/+QAoP9XAKH/WACi/1gAo/9aAKT/WQCl/1gApv9EAKf/uACo/+oAqf/sALD/uACx/+kAsv+zALP/tAC0/7UAtf+1ALb/tQC4/7YAuf/lALr/5gC7/+cAvP/nAL3/5QC//+UAwf+rAML/qgDD/9QAxP+4AMX/5ADG/6oAx//qAMn/6wAYACT/2QAt/8gARP/ZAEsAFABMABQATf/GAID/2QCB/9kAgv/ZAIP/2QCE/9kAhf/ZAIb/tACeABQAoP/RAKH/0wCi/9MAo//UAKT/1ACl/9IApv+wAMH/0ADC/9AAxv/lAD4AJP94ACb/2gAq/9oALf+hADD/1gAy/9kANP/aADb/5gBE/3YARv/OAEr/zQBN/6QAUP/NAFL/zQBU/84AVv/ZAFf/6gCA/3gAgf94AIL/eACD/3gAhP94AIX/eACG/0sAh//aAJD/xwCS/9kAk//ZAJT/2QCV/9kAlv/ZAJj/2gCf/+YAoP9wAKH/cQCi/3EAo/9yAKT/cgCl/3EApv9HAKf/zgCo/+wAsP+8ALH/6gCy/8YAs//IALT/yAC1/8kAtv/JALj/ywC5/+YAuv/oALv/6AC8/+kAvf/nAL//6QDB/64Awv+uAMP/2QDE/80Axf/mAMb/tQAVACT/yQAt/8kARP/LAE3/yQCA/8kAgf/JAIL/yQCD/8kAhP/JAIX/yQCG/7EAoP/DAKH/xACi/8UAo//FAKT/xQCl/8QApv+vAMH/ywDC/80Axv/aACYAJv/KACr/yQAy/8oANP/KAEb/1gBK/9UAUv/WAFT/1gBX/9AAWP/UAFn/1QBa/9oAXP/ZAIf/ygCQ/8MAkv/KAJP/ygCU/8oAlf/KAJb/ygCY/8wApv/pAKf/1gCw/8sAsv/RALP/0gC0/9MAtf/TALb/0wC4/9QAuf/NALr/zgC7/88AvP/PAL3/1QC//9cAw//KAMT/1gBZACT/aQAm/8YAKv/FAC3/nAAw/8oAMv/FADT/xQA2/9gAN//sAET/agBF/+QARv+yAEf/6QBI/+MASf/kAEr/sQBL/+gATP/mAE3/mABO/+gAT//dAFD/uwBR/+AAUv+xAFP/5ABU/7IAVf/kAFb/wgBX/9sAWP/fAFn/3wBa/+QAW//oAFz/4QBd/+IAgP9pAIH/aQCC/2kAg/9pAIT/aQCF/2kAhv9YAIf/xgCQ/7cAkv/FAJP/xQCU/8UAlf/FAJb/xQCY/8YAn//YAKD/ZQCh/2YAov9nAKP/ZwCk/2cApf9mAKb/VQCn/7IAqP/dAKn/3wCq/98Aq//gAKz/4wCt/+QArv/rALD/rwCx/9wAsv+rALP/rAC0/60Atf+tALb/rQC4/68Auf/XALr/2AC7/9kAvP/ZAL3/3AC//94Awf+mAML/nQDD/8UAxP+xAMX/2ADG/54Ayf/eAOb/5ADn/+QAFQAm/+oAKv/pADL/6QA0/+kAhv/oAIf/6gCQ/8kAkv/pAJP/6QCU/+kAlf/pAJb/6QCY/+oApv/lALD/zgCy/+kAs//qALT/6wC1/+sAtv/rAMP/6QABAD//pgAoAEb/4wBK/+IAUv/jAFT/4wBX/5MAWP/hAFn/iwBa/8gAXP9yAIf/3ACQ/8UAkv/cAJP/3ACU/9wAlf/cAJb/3ACY/90Amf/WAJr/1gCb/9YAnP/WAJ3/WACm/+UAp//jALD/0gCy/+MAs//jALT/4wC1/+MAtv/jALj/5AC5/94Auv/eALv/3gC8/94Avf9vAL//awDD/9wAxP/jAMf/WAAIAFv/6gBc/+UAhv/hAJ3/wQCm/9gAvf/hAL//4ADH/8EAGwBE/+MATf/SAFf/6ABZ/+kAW//aAFz/1wCA/+cAgf/nAIL/5wCD/+cAhP/nAIX/5wCG/8UAnf+xAKD/4wCh/+MAov/jAKP/4wCk/+MApf/jAKb/uwC9/9MAv//TAMH/3QDC/9wAxv/lAMf/sQAdAET/2gBN/8MAV//aAFn/4ABb/8gAXP/IAF3/6ACA/94Agf/eAIL/3gCD/94AhP/eAIX/3gCG/7sAnf+hAKD/2gCh/9oAov/aAKP/2gCk/9oApf/aAKb/sQC9/8QAv//DAMH/0gDC/9AAxv/kAMf/oQDJ/+gAEABG/+sASv/rAFL/7ABU/+sAkP/dAJ3/3gCm/+gAp//rALD/3wCy/+wAs//sALT/7AC1/+wAtv/sAMT/7ADH/94AJgBE/6MARv/hAEr/4ABN/6sAUP/gAFL/4ABU/+EAgP+pAIH/qQCC/6kAg/+pAIT/qQCF/6kAhv92AJD/0gCd/9QAoP+jAKH/owCi/6MAo/+jAKT/owCl/6MApv9rAKf/4QCw/9QAsv/gALP/4AC0/+AAtf/gALb/4AC4/+EAvf/sAL//7ADB/7MAwv+9AMT/4ADG/88Ax//UAAUAXP/cAJ3/twC9/9gAv//XAMf/twAlAEUAGABHABkASAAYAEkAGABLABkATAAZAE4AGQBPABcAUAAUAFEAGABTABgAVQAYAFgAFQCIABoAiQAaAIoAGgCLABoAjAAaAI0AGgCOABoAjwAaAJEAGQCd/+cAngAZAKgAGACpABgAqgAYAKsAGACsABkArQAZAK4AGQCvABkAsQAYAL4AGgDH/+cA5gAYAOcAGAAiAEUAFgBHABcASAAWAEkAFwBLABcATAAXAE4AFwBPABgAUQAXAFMAFwBVABYAWAAUAIgAGACJABgAigAYAIsAGACMABgAjQAYAI4AGACPABgAkQAYAJ4AGQCoABYAqQAWAKoAFgCrABYArAAXAK0AFwCuABcArwAXALEAFwC+ABkA5gAXAOcAFwAVAET/2ABN/8IAgP/dAIH/3QCC/90Ag//dAIT/3QCF/90Ahv+4AJ3/6ACg/9gAof/YAKL/2ACj/9gApP/YAKX/2ACm/64Awf/QAML/zQDG/+kAx//oABkARv/nAEr/5gBS/+cAVP/nAIf/3wCQ/8gAkv/fAJP/3wCU/98Alf/fAJb/3wCY/+AAnf/eAKf/5wCw/9AAsv/nALP/5wC0/+cAtf/nALb/5wC4/+gAvf/rAMP/3wDE/+cAx//eACoARv/eAEr/3QBS/94AVP/eAFf/jABY/9oAWf93AFr/xQBb/+wAXP9rAIb/4wCH/9QAkP+6AJL/1ACT/9QAlP/UAJX/1ACW/9QAmP/VAJn/zACa/8wAm//MAJz/zACd/1IApv/bAKf/3gCw/8MAsv/eALP/3gC0/94Atf/eALb/3gC4/98Auf/aALr/2gC7/9oAvP/aAL3/awC//2IAw//UAMT/3gDH/1IACABX/9YAWf/WAFr/3gBc/8oAnf+sAL3/xwC//8cAx/+sACIARQAXAEcAGABIABgASQAYAEsAGABMABgATgAYAE8AGQBRABcAUwAYAFUAGABYABYAiAAZAIkAGQCKABkAiwAZAIwAGQCNABkAjgAZAI8AGQCRABgAngAZAKgAGACpABgAqgAYAKsAGACsABgArQAYAK4AGACvABgAsQAXAL4AGQDmABgA5wAYABsARP/eAE3/zQBX/+EAWf/lAFv/0ABc/84AgP/jAIH/4wCC/+MAg//jAIT/4wCF/+MAhv/BAJ3/qACg/94Aof/eAKL/3gCj/94ApP/eAKX/3gCm/7cAvf/LAL//ygDB/9kAwv/YAMb/5gDH/6gAHABE/6sATf+qAFf/6ABZ/+gAW//eAFz/2QCA/7EAgf+xAIL/sQCD/7EAhP+xAIX/sQCG/3IAnf+2AKD/qwCh/6sAov+rAKP/qwCk/6sApf+rAKb/ZgC9/9YAv//VAMH/swDC/74Axv/ZAMf/tgDI/9gAHABE/98ATf/aAFf/4wBZ/+cAW//bAFz/0QCA/+QAgf/kAIL/5ACD/+QAhP/kAIX/5ACG/8wAnf+rAKD/3wCh/98Aov/fAKP/3wCk/98Apf/fAKb/xgC9/80AvgAUAL//zADB/9kAwv/YAMb/5wDH/6sABQBc/+EAnf+9AL3/3QC//9wAx/+9AA4ARP/qAE3/5ACG/9QAkP/qAJ3/2wCg/+oAof/qAKL/6gCj/+oApP/qAKX/6gCm/8sAwv/sAMf/2wAkAET/fgBG/98ASv/eAE3/qwBQ/98AUv/eAFT/3wCA/4YAgf+GAIL/hgCD/4YAhP+GAIX/hgCG/2gAkP+/AJ3/2QCg/34Aof9+AKL/fgCj/34ApP9+AKX/fgCm/2AAp//fALD/xQCy/94As//eALT/3gC1/94Atv/eALj/3wDB/7IAwv+7AMT/3gDG/84Ax//ZADMARP/jAEUAFQBHABYASAAVAEkAFgBLABYATAAWAE3/1gBOABYATwAVAFEAFQBTABYAVQAWAID/5gCB/+YAgv/mAIP/5gCE/+YAhf/mAIb/yACIABYAiQAWAIoAFgCLABYAjAAWAI0AFgCOABYAjwAWAJEAFgCeABYAoP/jAKH/4wCi/+MAo//jAKT/4wCl/+MApv++AKgAFQCpABUAqgAVAKsAFQCsABYArQAWAK4AFgCvABYAsQAVAL4AFgDB/98Awv/eAOYAFgDnABYAJABE/5AARv/mAEr/5gBN/7IAUP/iAFL/5gBU/+YAgP+WAIH/lgCC/5YAg/+WAIT/lgCF/5YAhv9uAJD/4ACd/+cAoP+QAKH/kACi/5AAo/+QAKT/kACl/5AApv9lAKf/5gCw/9UAsv/mALP/5gC0/+YAtf/mALb/5gC4/+YAwf+6AML/wQDE/+YAxv/RAMf/5wAVAET/1ABN/9MAgP/XAIH/1wCC/9cAg//XAIT/1wCF/9cAhv/CAJ3/6wCg/9QAof/UAKL/1ACj/9QApP/UAKX/1ACm/7kAwf/YAML/2QDG/+YAx//rABYARv/VAEr/1ABS/9UAVP/VAIf/4gCQ/8cAkv/hAJP/4QCU/+EAlf/hAJb/4QCY/+IAp//VALD/zgCy/9UAs//VALT/1QC1/9UAtv/VALj/1gDD/+EAxP/VAC0ARP+CAEb/1ABK/9QATf+uAFD/2ABS/9QAVP/UAFb/4wCA/4QAgf+EAIL/hACD/4QAhP+EAIX/hACG/3YAh//mAJD/xgCS/+UAk//lAJT/5QCV/+UAlv/lAJj/5gCd/+YAoP+CAKH/ggCi/4IAo/+CAKT/ggCl/4IApv9vAKf/1ACw/8cAsv/UALP/1AC0/9QAtf/UALb/1AC4/9QAwf+2AML/uQDD/+UAxP/UAMb/xADH/+YABQCQ/+UAnf/sAKb/6QCw/9MAx//sAEQAJv/YACr/1wAy/9gANP/YADf/fgA4/9gAOf92ADr/vgA8/1kARv/oAEr/6ABS/+kAVP/pAFf/lgBY/+cAWf+VAFr/zABc/3sAgP/fAIH/4ACC/+IAg//kAIT/5ACF/+AAhv/kAIf/2ACI/+kAif/pAIr/6wCQ/8kAkv/IAJP/yACU/8oAlf/MAJb/zQCY/9QAmf/CAJr/wwCb/8UAnP/HAJ3/SACg/+cAof/oAKL/5wCj/+oApP/rAKX/5gCm/+YAp//oALD/2gCy/9YAs//WALT/1QC1/9gAtv/aALj/5AC5/9EAuv/SALv/0QC8/9UAvf9oAL//ZwDD/9gAxP/pAMX/6gDG/+MAx/9MAMj/7ABEACb/2AAq/9cAMv/YADT/2AA3/34AOP/YADn/dgA6/74APP9ZAEb/6ABK/+gAUv/pAFT/6QBX/5YAWP/nAFn/lQBa/8wAXP97AID/3wCB/98Agv/hAIP/4wCE/+MAhf/gAIb/5ACH/9gAiP/oAIn/6QCK/+oAkP/JAJL/xwCT/8gAlP/JAJX/ywCW/8wAmP/TAJn/wgCa/8IAm//EAJz/xwCd/0cAoP/mAKH/5gCi/+UAo//pAKT/6gCl/+UApv/mAKf/6ACw/9oAsv/UALP/1QC0/9MAtf/XALb/2QC4/+QAuf/QALr/0AC7/88AvP/UAL3/ZwC//2YAw//YAMT/6QDF/+oAxv/hAMf/SwDI/+sARAAm/9gAKv/XADL/2AA0/9gAN/9+ADj/2AA5/3YAOv++ADz/WQBG/+gASv/oAFL/6QBU/+kAV/+WAFj/5wBZ/5UAWv/MAFz/ewCA/+EAgf/hAIL/4QCD/+UAhP/mAIX/4ACG/+QAh//YAIj/6gCJ/+sAiv/qAJD/yQCS/8kAk//KAJT/yQCV/84Alv/OAJj/1ACZ/8QAmv/FAJv/xACc/8kAnf9JAKD/6ACh/+gAov/oAKP/6gCk/+wApf/nAKb/5gCn/+gAsP/aALL/1gCz/9cAtP/WALX/2QC2/9oAuP/kALn/0gC6/9IAu//RALz/1gC9/2kAv/9oAMP/2ADE/+kAxf/qAMb/5ADH/00AyP/rAEAAJv/YACr/1wAy/9gANP/YADf/fgA4/9gAOf92ADr/vgA8/1kARv/oAEr/6ABS/+kAVP/pAFf/lgBY/+cAWf+VAFr/zABc/3sAgP/iAIH/4wCC/+QAg//lAIT/5gCF/+MAhv/kAIf/2ACI/+wAkP/JAJL/ywCT/8wAlP/NAJX/zgCW/84AmP/TAJn/xQCa/8YAm//IAJz/yQCd/0sAoP/nAKH/5wCi/+cAo//qAKT/6wCl/+YApv/mAKf/6ACw/9oAsv/VALP/1gC0/9UAtf/YALb/2QC4/+QAuf/RALr/0QC7/9EAvP/VAL3/aAC//2cAw//YAMT/6QDG/+MAx/9NAD8AJv/YACr/1wAy/9gANP/YADf/fgA4/9gAOf92ADr/vgA8/1kARv/oAEr/6ABS/+kAVP/pAFf/lgBY/+cAWf+VAFr/zABc/3sAgP/jAIH/5ACC/+YAg//nAIT/5wCF/+UAhv/kAIf/2ACQ/8kAkv/MAJP/zQCU/84Alf/PAJb/0ACY/9QAmf/HAJr/yACb/8kAnP/KAJ3/TACg/+gAof/pAKL/6ACj/+sApP/sAKX/6ACm/+YAp//oALD/2gCy/9cAs//XALT/1gC1/9kAtv/aALj/5AC5/9IAuv/TALv/0gC8/9YAvf9pAL//aQDD/9gAxP/pAMb/5ADH/08ARAAm/9gAKv/XADL/2AA0/9gAN/9+ADj/2AA5/3YAOv++ADz/WQBG/+gASv/oAFL/6QBU/+kAV/+WAFj/5wBZ/5UAWv/MAFz/ewCA/+AAgf/hAIL/4ACD/+QAhP/lAIX/3gCG/+QAh//YAIj/6gCJ/+oAiv/pAJD/yQCS/8gAk//JAJT/yACV/80Alv/NAJj/0wCZ/8MAmv/EAJv/wwCc/8gAnf9IAKD/5wCh/+cAov/nAKP/6gCk/+sApf/mAKb/5gCn/+gAsP/aALL/1QCz/9YAtP/VALX/2AC2/9kAuP/kALn/0QC6/9EAu//QALz/1QC9/2gAv/9nAMP/2ADE/+kAxf/pAMb/4gDH/0wAyP/rABUAJv/mACr/5gAy/+UANP/mAIb/5gCH/+YAkP/XAJL/5QCT/+UAlP/lAJX/5QCW/+UAmP/mAKb/5ACw/9YAsv/pALP/6gC0/+oAtf/rALb/6wDD/+UAJgAk/9UALf+/ADT/6gA3/9kAOf/bADr/6QA7/8sAPP/GAD3/5gBE/9UATf+9AFv/6gBc/+MAgP/RAIH/0QCC/9EAg//RAIT/0QCF/9EAhv+tAIf/4gCQ/+AAnf/CAKD/zACh/80Aov/OAKP/zwCk/88Apf/NAKb/qgCn/+oAvf/ZAL//2ADB/8gAwv/IAMb/zgDH/8IAyP/iAB4AJv/iACr/4gAy/+IANP/iAID/5gCB/+cAgv/oAIP/6wCE/+sAhf/nAIb/5gCH/+IAkP/XAJL/0wCT/9MAlP/VAJX/1wCW/9gAmP/dAJ3/5ACm/+QAsP/WALL/4QCz/+IAtP/hALX/5AC2/+UAw//iAMb/6wDH/+gAIwAm/+IAKv/iADL/4gA0/+IAgP/mAIH/5gCC/+gAg//qAIT/6gCF/+cAhv/mAIf/4gCQ/9cAkv/SAJP/0wCU/9QAlf/WAJb/1wCY/90Anf/jAKD/7ACi/+sApf/rAKb/5ACw/9YAsv/gALP/4AC0/98Atf/iALb/5AC7/+wAvf/rAMP/4gDG/+oAx//nABwAJv/iACr/4gAy/+IANP/iAID/6ACB/+gAgv/oAIP/7ACF/+cAhv/mAIf/4gCQ/9cAkv/UAJP/1QCU/9QAlf/ZAJb/2QCY/94Anf/lAKb/5ACw/9YAsv/iALP/4gC0/+EAtf/kALb/5gDD/+IAx//pABoAJv/iACr/4gAy/+IANP/iAID/6gCB/+sAhf/rAIb/5gCH/+IAkP/XAJL/1wCT/9gAlP/ZAJX/2gCW/9oAmP/eAJ3/6ACm/+QAsP/WALL/4gCz/+IAtP/iALX/5QC2/+YAw//iAMf/6wAZACUAFgAnABcAKAAXACkAFwArABcALAAXAC4AFwAvABcAMQAXADMAFwA1ABcARQAWAEcAFwBIABYASQAXAEsAGABMABgATgAXAE8AGABRABcAUwAXAFUAFwC+ABYA5gAXAOcAFwAZACUAFgAnABcAKAAXACkAFwArABcALAAXAC4AFwAvABcAMQAXADMAFwA1ABcARQAWAEcAFwBIABYASQAXAEsAGABMABgATgAXAE8AGABRABcAUwAXAFUAFwC+ABUA5gAXAOcAFwAbACUAFgAnABcAKAAXACkAFwArABcALAAXAC4AFwAvABcAMQAXADMAFwA1ABcARQAWAEcAFwBIABYASQAXAEsAGABMABgATgAXAE8AGABRABcAUwAXAFUAFwCeABUArwAUAL4AFgDmABcA5wAXABwAJQAWACcAFwAoABcAKQAXACsAFwAsABcALgAXAC8AFwAxABcAMwAXADUAFwBFABYARwAXAEgAFgBJABcASwAYAEwAGABOABcATwAYAFEAFwBTABcAVQAXAI8AFQCeABYArwAVAL4AFgDmABcA5wAXABwAJQAZACcAGgAoABoAKQAZACsAGgAsABoALgAaAC8AGQAwABQAMQAZADMAGQA1ABkARQAZAEcAGgBIABoASQAaAEsAGwBMABsATgAbAE8AGQBQABUAUQAaAFMAGgBVABoAWAAWAL4AFQDmABoA5wAaACMAJP/VAC3/vgA3/9YAOf/aADv/xwA8/8IAPf/mAET/1wBN/74AW//pAFz/4QCA/8IAgf/CAIL/xACD/8YAhP/HAIX/wwCG/60Anf+wAKD/xwCh/8gAov/HAKP/ygCk/8wApf/GAKb/rAC9/9EAv//RAMH/yQDC/84Axf/oAMb/2QDH/7QAyP/UAMn/6AAjACT/1QAt/74AN//WADn/2gA7/8cAPP/CAD3/5gBE/9cATf++AFv/6QBc/+EAgP/BAIH/wgCC/8MAg//FAIT/xgCF/8IAhv+tAJ3/rwCg/8YAof/GAKL/xQCj/8kApP/KAKX/xQCm/6wAvf/QAL//zwDB/8kAwv/OAMX/5wDG/9cAx/+zAMj/1ADJ/+cAIwAk/9UALf++ADf/1gA5/9oAO//HADz/wgA9/+YARP/XAE3/vgBb/+kAXP/hAID/wwCB/8QAgv/DAIP/yACE/8gAhf/CAIb/rQCd/7EAoP/IAKH/yACi/8cAo//LAKT/zACl/8cApv+sAL3/0gC//9IAwf/JAML/zgDF/+cAxv/aAMf/tQDI/9QAyf/pACMAJP/VAC3/vgA3/9YAOf/aADv/xwA8/8IAPf/mAET/1wBN/74AW//pAFz/4QCA/8UAgf/FAIL/xwCD/8gAhP/IAIX/xgCG/60Anf+zAKD/xwCh/8gAov/HAKP/ygCk/8sApf/GAKb/rAC9/9EAv//RAMH/yQDC/84Axf/rAMb/2QDH/7YAyP/XAMn/6AAiACT/1QAt/74AN//WADn/2gA7/8cAPP/CAD3/5gBE/9cATf++AFv/6QBc/+EAgP/GAIH/xwCC/8gAg//JAIT/ygCF/8cAhv+tAJ3/tACg/8gAof/JAKL/yACj/8sApP/MAKX/yACm/6wAvf/SAL//0gDB/8kAwv/OAMb/2gDH/7cAyP/YAMn/6gAhACT/1gAt/78AN//WADn/2gA7/8cAPP/CAD3/5wBE/9cATf++AFv/6QBc/+EAgP/QAIH/0QCC/9IAg//SAIT/0gCF/9EAhv+uAJ3/vgCg/80Aof/NAKL/zgCj/88ApP/PAKX/zgCm/6wAvf/XAL//1gDB/8kAwv/OAMb/3QDH/74AyP/iABkAJP/ZAC3/yABE/9kASwAUAEwAFABN/8YAgP/DAIH/xACC/8YAg//IAIT/yACF/8UAhv+0AJ3/5wCg/8kAof/KAKL/yQCj/8wApP/NAKX/yACm/7AAwf/QAML/0ADG/9sAx//rABkAJP/ZAC3/yABE/9kASwAUAEwAFABN/8YAgP/DAIH/wwCC/8UAg//HAIT/yACF/8QAhv+0AJ3/5gCg/8gAof/IAKL/xwCj/8sApP/MAKX/xgCm/7AAwf/QAML/0ADG/9oAx//qABgAJP/ZAC3/yABE/9kASwAUAEwAFABN/8YAgP/FAIH/xgCC/8UAg//JAIT/ygCF/8QAhv+0AJ3/6ACg/8oAof/KAKL/yQCj/8wApP/OAKX/yQCm/7AAwf/QAML/0ADG/9wAGAAk/9kALf/IAET/2QBLABQATAAUAE3/xgCA/8gAgf/JAIL/ygCD/8sAhP/LAIX/yQCG/7QAnf/rAKD/ygCh/8sAov/KAKP/zQCk/84Apf/KAKb/sADB/9AAwv/QAMb/3QBoACT/aQAm/8IAKv/CAC3/nAAw/8oAMv/BADT/wgA2/9QAN//sAET/agBF/+QARv+yAEf/6QBI/+MASf/kAEr/sQBL/+gATP/mAE3/mABO/+gAT//dAFD/uwBR/+AAUv+xAFP/5ABU/7IAVf/kAFb/wgBX/9sAWP/fAFn/3wBa/+QAW//oAFz/4QBd/+IAgP9XAIH/VwCC/1kAg/9bAIT/WwCF/1gAhv9YAIf/wgCI/+IAif/jAIr/5ACL/+cAjP/qAI3/6gCO/+wAkP+3AJH/4gCS/7IAk/+zAJT/tACV/7YAlv+3AJj/vACZ/9wAmv/dAJv/3wCc/+EAnf/dAJ//1ACg/10Aof9dAKL/XACj/18ApP9hAKX/XACm/1UAp/+yAKj/1QCp/9UAqv/UAKv/2QCs/90Arf/dAK7/4wCw/68Asf/UALL/ogCz/6IAtP+hALX/pQC2/6YAuP+vALn/zgC6/88Au//OALz/0gC9/9QAv//XAMH/pgDC/50Aw//BAMT/sQDF/8cAxv+VAMf/4QDI/+MAyf/VAOb/5ADn/+QAPQAk/5sALf+aADD/5gA3/98AOf/fADr/6AA7/9YAPP/OAD3/6gBE/5cATf+mAFD/4wBX/+sAWf/sAFz/5QCA/4oAgf+LAIL/jQCD/44AhP+OAIX/jACG/1AAiP/rAJD/6gCS/+AAk//hAJT/4gCV/+MAlv/kAJj/6gCZ/+YAmv/nAJv/6QCc/+oAnf+/AKD/jACh/4wAov+LAKP/jgCk/5AApf+LAKb/SQCw/90Asv/fALP/3wC0/94Atf/iALb/4wC4/+kAuf/qALr/6wC7/+oAvf/ZAL//2QDB/60Awv+3AMX/4ADG/8YAx//CAMj/2wDJ/+cAQAAm/9MAKv/SADL/0wA0/9MAN/96ADj/0AA5/2sAOv+4ADz/VgBG/+MASv/iAFL/4wBU/+MAV/+TAFj/4QBZ/4sAWv/IAFz/cgCA/+cAgf/oAIL/6QCD/+kAhP/pAIX/5wCG/+EAh//TAJD/vwCS/8wAk//NAJT/zgCV/84Alv/OAJj/zgCZ/8YAmv/HAJv/yACc/8gAnf9OAKD/5wCh/+cAov/pAKP/6gCk/+sApf/oAKb/5QCn/+MAsP/SALL/0QCz/9IAtP/TALX/1AC2/9UAuP/dALn/zAC6/80Au//OALz/0AC9/2AAv/9dAMH/7ADD/9MAxP/jAMb/4gDH/08AQAAm/9IAKv/RADL/0gA0/9IAN/95ADj/zwA5/2oAOv+3ADz/VQBG/+MASv/iAFL/4wBU/+MAV/+TAFj/4QBZ/4sAWv/IAFz/cgCA/+YAgf/oAIL/6ACD/+gAhP/oAIX/5wCG/+AAh//SAJD/vgCS/8sAk//NAJT/zQCV/84Alv/OAJj/zgCZ/8YAmv/HAJv/yACc/8gAnf9OAKD/5wCh/+cAov/oAKP/6QCk/+oApf/oAKb/5QCn/+MAsP/SALL/0QCz/9EAtP/TALX/0wC2/9UAuP/cALn/zAC6/8wAu//OALz/0AC9/2AAv/9dAMH/6wDD/9IAxP/jAMb/4gDH/08APgAm/9QAKv/TADL/1AA0/9MAN/97ADj/0QA5/2wAOv+5ADz/VgBG/+MASv/iAFL/4wBU/+MAV/+TAFj/4QBZ/4sAWv/IAFz/cgCA/+UAgf/nAIL/6ACD/+gAhP/oAIX/5wCG/+IAh//UAJD/vwCS/8oAk//MAJT/zQCV/80Alv/NAJj/zwCZ/8UAmv/GAJv/xwCc/8gAnf9NAKD/6ACh/+kAov/oAKP/6wCl/+cApv/lAKf/4wCw/9IAsv/SALP/0wC0/9IAtf/VALb/1gC4/90Auf/NALr/zgC7/80AvP/RAL3/YQC//14Aw//UAMT/4wDG/+IAx/9PAD4AJv/UACr/0wAy/9QANP/UADf/ewA4/9EAOf9sADr/uQA8/1YARv/jAEr/4gBS/+MAVP/jAFf/kwBY/+EAWf+LAFr/yABc/3IAgP/pAIH/6gCC/+sAg//rAIT/6wCF/+oAhv/iAIf/1ACQ/78Akv/OAJP/zwCU/9AAlf/QAJb/0ACY/9AAmf/IAJr/ygCb/8oAnP/LAJ3/UACg/+kAof/qAKL/6wCj/+wApf/qAKb/5QCn/+MAsP/SALL/0wCz/9QAtP/VALX/1gC2/9cAuP/dALn/zgC6/88Au//QALz/0gC9/2IAv/9fAMP/1ADE/+MAxv/lAMf/UQA5ACb/1AAq/9MAMv/UADT/1AA3/3sAOP/RADn/bAA6/7kAPP9jAEb/4wBK/+IAUv/jAFT/4wBX/5MAWP/hAFn/iwBa/8gAXP9yAID/6gCB/+wAhf/rAIb/4gCH/9QAkP/AAJL/0ACT/9EAlP/RAJX/0gCW/9IAmP/RAJn/ygCa/8sAm//MAJz/zACd/14AoP/qAKH/6wCl/+sApv/lAKf/4wCw/9IAsv/VALP/1QC0/9cAtf/XALb/2AC4/90Auf/QALr/0AC7/9IAvP/TAL3/ZAC//2AAw//UAMT/4wDG/+YAx/9eAEAAJv/TACr/0gAy/9MANP/TADf/egA4/9AAOf9rADr/uAA8/1UARv/jAEr/4gBS/+MAVP/jAFf/kwBY/+EAWf+LAFr/yABc/3IAgP/lAIH/5wCC/+cAg//oAIT/6ACF/+YAhv/hAIf/0wCQ/78Akv/KAJP/ywCU/8wAlf/NAJb/zQCY/88Amf/EAJr/xgCb/8cAnP/HAJ3/TQCg/+gAof/oAKL/5wCj/+oApP/rAKX/5wCm/+UAp//jALD/0gCy/9IAs//SALT/0QC1/9QAtv/WALj/3QC5/80Auv/NALv/zAC8/9EAvf9hAL//XQDB/+wAw//TAMT/4wDG/+EAx/9OABIAPP/eAEb/6gBK/+oAUv/qAFT/6gCQ/9wAnf/eAKb/5wCn/+oAsP/eALL/6gCz/+oAtP/qALX/6gC2/+oAuP/rAMT/6gDH/94AIgAk/+cALf/WADf/wwA5/9EAOv/qADv/xgA8/7EARP/jAE3/0gBX/+gAWf/pAFv/2gBc/9cAgP/nAIH/5wCC/+cAg//nAIT/5wCF/+cAhv/FAJ3/sQCg/+MAof/jAKL/4wCj/+MApP/jAKX/4wCm/7sAvf/TAL//0wDB/90Awv/cAMb/4wDH/7EAGAA8/9wARv/rAEr/6wBS/+wAVP/rAIb/5gCQ/9gAkv/qAJP/7ACd/9UApv/oAKf/6wCw/98Asv/bALP/2wC0/90Atf/dALb/3wC4/+YAvf/pAL//6gDE/+wAxv/sAMf/1gAYADz/2wBG/+sASv/rAFL/7ABU/+sAhv/lAJD/1wCS/+oAk//sAJ3/1QCm/+gAp//rALD/3wCy/9oAs//bALT/3AC1/90Atv/eALj/5QC9/+gAv//pAMT/7ADG/+sAx//WABkAPP/dAEb/6wBK/+sAUv/sAFT/6wCG/+YAkP/ZAJL/6QCT/+sAlP/sAJ3/1QCm/+gAp//rALD/3wCy/9wAs//cALT/2wC1/98Atv/gALj/5gC9/+oAv//qAMT/7ADG/+sAx//WABMAPP/eAEb/6wBK/+sAUv/sAFT/6wCG/+cAkP/ZAJ3/2QCm/+gAp//rALD/3wCy/94As//fALT/4AC1/+EAtv/hALj/5gDE/+wAx//ZAB0AJQAUACcAFQAoABQAKQAVACsAFQAsABUALgAVAC8AFQAxABUAMwAVADUAFQBFABYARwAXAEgAFgBJABcASwAXAEwAFwBOABcATwAYAFEAFwBTABcAVQAWAFgAFACd/+kAngAVAL4AFQDH/+oA5gAXAOcAFwAWACcAFAArABQALAAUAC4AFABFABYARwAXAEgAFgBJABcASwAXAEwAFwBOABcATwAYAFEAFwBTABcAVQAWAFgAFACd/+gAngAVAL4AFADH/+kA5gAXAOcAFwAdACUAFQAnABYAKAAVACkAFQArABYALAAWAC4AFgAvABUAMQAVADMAFQA1ABUARQAWAEcAFwBIABYASQAXAEsAFwBMABcATgAXAE8AGABRABcAUwAXAFUAFgBYABQAnf/oAJ4AFgC+ABYAx//qAOYAFwDnABcAHwAlABUAJwAWACgAFQApABYAKwAWACwAFgAuABYALwAWADEAFgAzABYANQAWAEUAFgBHABcASAAWAEkAFwBLABcATAAXAE4AFwBPABgAUQAXAFMAFwBVABYAWAAUAI0AFACOABUAjwAVAJ4AGACvABUAvgAXAOYAFwDnABcAJAAk/94ALf/IADf/rwA5/8QAOv/mADv/uwA8/6EARP/aAE3/wwBX/9oAWf/gAFv/yABc/8gAXf/oAID/3gCB/94Agv/eAIP/3gCE/94Ahf/eAIb/uwCd/6EAoP/aAKH/2gCi/9oAo//aAKT/2gCl/9oApv+xAL3/xAC//8MAwf/SAML/0ADG/+QAx/+hAMn/6AARADz/6wBFABcARwAYAEgAGABJABgASwAYAEwAGABOABgATwAZAFEAFwBTABgAVQAYAFgAFgCd/+QAx//lAOYAGADnABgAJgAk/9kALf/KADf/tQA5/8YAOv/kADv/vQA8/6UAPf/sAET/3gBN/80AV//hAFn/5QBb/9AAXP/OAID/zwCB/9EAgv/RAIP/0gCE/9IAhf/QAIb/tgCd/50AoP/NAKH/zQCi/88Ao//PAKT/0QCl/84Apv+3AL3/uwC//7sAwf/SAML/2ADF/+gAxv/VAMf/ngDI/+MAyf/dACYAJP/YAC3/yQA3/7QAOf/FADr/4wA7/7wAPP+kAD3/6wBE/94ATf/NAFf/4QBZ/+UAW//QAFz/zgCA/88Agf/QAIL/0QCD/9EAhP/RAIX/0ACG/7UAnf+dAKD/zQCh/80Aov/OAKP/zwCk/9AApf/NAKb/twC9/7sAv/+6AMH/0QDC/9gAxf/oAMb/1QDH/54AyP/jAMn/3QAlACT/2gAt/8sAN/+2ADn/xwA6/+QAO/++ADz/pgBE/94ATf/NAFf/4QBZ/+UAW//QAFz/zgCA/84Agf/PAIL/0ACD/9EAhP/RAIX/zwCG/7YAnf+cAKD/zgCh/88Aov/NAKP/0QCk/9IApf/NAKb/twC9/7wAv/+7AMH/0gDC/9gAxf/nAMb/1QDH/50AyP/iAMn/3QAlACT/2gAt/8sAN/+2ADn/xwA6/+QAO/++ADz/pgBE/94ATf/NAFf/4QBZ/+UAW//QAFz/zgCA/9IAgf/TAIL/0wCD/9QAhP/UAIX/0gCG/7YAnf+fAKD/zwCh/88Aov/RAKP/0gCk/9MApf/QAKb/twC9/70Av/+9AMH/0gDC/9gAxf/qAMb/1wDH/6AAyP/lAMn/3wAlACT/2gAt/8sAN/+2ADn/xwA6/+UAO/++ADz/pgBE/94ATf/NAFf/4QBZ/+UAW//QAFz/zgCA/9MAgf/UAIL/1QCD/9UAhP/VAIX/1ACG/7cAnf+hAKD/0ACh/9EAov/SAKP/0wCk/9MApf/RAKb/twC9/78Av/++AMH/0wDC/9gAxf/sAMb/2QDH/6EAyP/nAMn/4QAjACT/4gAt/9EAN/+9ADn/zAA6/+oAO//DADz/qwBE/98ATf/OAFf/4QBZ/+UAW//SAFz/zwCA/+IAgf/iAIL/4gCD/+IAhP/iAIX/4gCG/78Anf+rAKD/2wCh/9wAov/cAKP/3ACk/9wApf/bAKb/uAC9/8kAv//GAMH/2QDC/9gAxv/gAMf/qwDJ/+oAGgAk/9oALf/QADz/6ABE/98ATf/SAE8AFQCA/9AAgf/RAIL/0gCD/9IAhP/SAIX/0QCG/7kAnf/gAKD/zgCh/84Aov/QAKP/0ACk/9IApf/PAKb/ugC9/+sAwf/VAML/3gDG/9kAx//hABoAJP/ZAC3/zwA8/+cARP/fAE3/0gBPABUAgP/PAIH/0QCC/9EAg//SAIT/0gCF/9AAhv+4AJ3/4ACg/80Aof/OAKL/zwCj/9AApP/RAKX/zgCm/7oAvf/qAMH/1ADC/94Axv/ZAMf/4QAZACT/2gAt/9AAPP/pAET/3wBN/9IATwAVAID/zgCB/9AAgv/RAIP/0QCE/9EAhf/QAIb/ugCd/98AoP/PAKH/zwCi/84Ao//SAKT/0wCl/84Apv+6AMH/1gDC/94Axv/ZAMf/4QAZACT/2wAt/9EAPP/pAET/3wBN/9IATwAVAID/1ACB/9UAgv/VAIP/1QCE/9UAhf/UAIb/ugCd/+QAoP/RAKH/0gCi/9MAo//UAKT/1ACl/9IApv+6AMH/1gDC/94Axv/dAMf/5ABFACT/eAAm/9oAKv/ZAC3/nAAw/9gAMv/ZADT/2QA2/+cAN//rADv/6gA8/+IARP9/AEb/0QBK/9AATf+qAFD/1QBS/9AAVP/RAFb/4ACA/3AAgf9yAIL/cgCD/3IAhP9yAIX/cQCG/2gAh//aAJD/vQCS/9MAk//UAJT/1QCV/9UAlv/VAJj/1QCd/9sAn//nAKD/cACh/3AAov9yAKP/cgCk/3MApf9xAKb/awCn/9EAqP/pAKn/6gCq/+sAsP/DALH/6ACy/78As//AALT/wQC1/8IAtv/DALj/ygC5/+UAuv/lALv/5gC8/+gAvf/jAL//5QDB/60Awv+5AMP/2QDE/9AAxf/iAMb/sgDH/9wAyf/rAC4AJP+qAC3/mQAw/+sANv/rADf/yAA5/9AAOv/iADv/tgA8/7UAPf/VAET/qwBN/6oAV//oAFn/6ABb/94AXP/ZAID/ogCB/6MAgv+jAIP/pACE/6QAhf+jAIb/aQCd/68An//rAKD/nQCh/54Aov+fAKP/oACk/6AApf+eAKb/ZgCy/+cAs//oALT/6QC1/+oAtv/qAL3/ygC//8oAwf+uAML/vgDF/+cAxv/MAMf/rwDI/84Ayf/jAD8AJP98ACb/2wAq/9sALf+fADD/2gAy/9sANP/bADb/6QA8/+YARP+DAEb/0gBK/9EATf+sAFD/1gBS/9EAVP/SAFb/4QCA/3QAgf92AIL/dgCD/3cAhP93AIX/dQCG/2wAh//bAJD/wACS/9UAk//WAJT/1wCV/9cAlv/XAJj/1wCd/+EAn//pAKD/dQCh/3UAov92AKP/eACk/3kApf91AKb/bwCn/9IAsP/FALH/6wCy/8IAs//CALT/wwC1/8QAtv/FALj/yQC5/+cAuv/oALv/6AC8/+sAvf/nAL//6QDB/68Awv+4AMP/2wDE/9EAxf/kAMb/tADH/+IAQwAk/+oAJv/UACr/0wAy/9QANP/UADf/lgA4/88AOf+YADr/ugA7/+YAPP+MAEb/4gBK/+EAUv/iAFT/4gBX/5gAWP/fAFn/nABa/8cAW//nAFz/nACA/+oAgf/qAIL/6gCD/+oAhP/qAIX/6gCG/9cAh//UAJD/twCS/9QAk//UAJT/1ACV/9QAlv/UAJj/1QCZ/88Amv/PAJv/zwCc/88Anf+MAKD/5QCh/+YAov/nAKP/5wCk/+cApf/mAKb/1wCn/+IAsP/DALL/2QCz/9oAtP/bALX/2wC2/9sAuP/eALn/0wC6/9QAu//VALz/1QC9/5MAv/+TAMH/6QDD/9QAxP/iAMb/5QDH/4wAMwAm/9YAKv/VADL/1gA0/9YAN/+SADj/zgA5/5cAOv+8ADv/7AA8/34ARv/gAEr/4ABS/+EAVP/gAFf/qQBY/9wAWf+pAFr/yABc/6AAhv/lAIf/1gCQ/7wAkv/WAJP/1gCU/9YAlf/WAJb/1gCY/9gAmf/OAJr/zgCb/84AnP/OAJ3/fgCm/94Ap//gALD/xgCy/+EAs//hALT/4QC1/+EAtv/hALj/4gC5/9wAuv/cALv/3AC8/9wAvf+gAL//nQDD/9YAxP/hAMf/fgAVACb/4gAq/+IAMv/hADT/4gCG/+YAh//iAJD/1wCS/+EAk//hAJT/4QCV/+EAlv/hAJj/4gCm/+QAsP/WALL/5QCz/+YAtP/nALX/6AC2/+gAw//hABEAPP/eAEb/6wBK/+sAUv/sAFT/6wCQ/94Anf/eAKb/6ACn/+sAsP/fALL/7ACz/+wAtP/sALX/7AC2/+wAxP/sAMf/3gAbACT/4wAt/90ARP/kAE3/2wCA/9EAgf/SAIL/0gCD/9YAhP/WAIX/0QCG/8YAkv/pAJP/6gCU/+kAnf/lAKD/1wCh/9cAov/WAKP/2QCk/9sApf/WAKb/wgDB/+IAwv/jAMX/6gDG/9sAx//pAB8AJP/qAC3/5wA3/+EAOf/iADr/6wA7/9kAPP/PAE3/6QBc/+0AgP/hAIH/4wCC/+QAg//kAIT/5ACF/+IAhv/SAJD/7ACZ/+8Anf/IAKD/4QCh/+IAov/hAKP/5ACk/+UApf/hAKb/0gC9/94Av//fAMH/6wDG/+YAx//KAGUAJP9pACb/wgAq/8IALf+cADD/ygAy/8EANP/CADb/1AA3/+wARP9qAEX/5ABG/7IAR//pAEj/4wBJ/+QASv+xAEv/6ABM/+YATf+YAE7/6ABP/90AUP+7AFH/4ABS/7EAU//kAFT/sgBV/+QAVv/CAFf/2wBY/98AWf/fAFr/5ABb/+gAXP/hAF3/4gCA/1sAgf9cAIL/XgCD/18AhP9fAIX/XQCG/1gAh//CAIj/5wCJ/+gAiv/pAIv/6wCQ/7cAkf/lAJL/twCT/7gAlP+5AJX/ugCW/7oAmP+9AJn/4QCa/+IAm//jAJz/5QCd/+IAn//UAKD/XwCh/18Aov9fAKP/YgCk/2MApf9fAKb/VQCn/7IAqP/XAKn/1wCq/9cAq//bAKz/3wCt/98Arv/mALD/rwCx/9YAsv+kALP/pQC0/6QAtf+nALb/qAC4/68Auf/QALr/0QC7/9EAvP/UAL3/1gC//9oAwf+mAML/nQDD/8EAxP+xAMX/zADG/5gAx//lAMj/6ADJ/9gA5v/kAOf/5AAeACb/5gAq/+YAMv/lADT/5gCA/+cAgf/oAIL/6ACD/+sAhP/sAIX/5wCG/+gAh//mAJD/yQCS/9YAk//XAJT/1wCV/9sAlv/bAJj/4ACd/+sApf/sAKb/5QCw/84Asv/hALP/4QC0/+AAtf/jALb/5QDD/+UAxv/rAA4APP/pAIb/5wCQ/98Anf/iAKb/6QCw/9MAsv/fALP/3wC0/98Atf/iALb/4wC4/+kAxv/rAMf/4wAtACUAGAAnABgAKAAYACkAGAArABgALAAYAC4AGAAvABgAMQAYADMAGAA1ABgARQAWAEcAFwBIABYASQAWAEsAFwBMABcATgAXAE8AGABRABcAUwAWAFUAFgBYABQAiAAYAIkAGACKABgAiwAYAIwAGACNABgAjgAYAI8AGACRABgAngAZAKgAFgCpABYAqgAWAKsAFgCsABcArQAXAK4AFwCvABcAsQAXAL4AGQDmABYA5wAWAD0AJv/QACr/zwAy/9AANP/QADf/dQA4/8gAOf9VADr/tgA7/+YAPP9PAET/6wBG/9oASv/ZAFL/2gBU/9oAV/+MAFj/2gBZ/3cAWv/CAFv/5gBc/2sAhv/eAIf/0ACQ/7YAkv/QAJP/0ACU/9AAlf/QAJb/0ACY/9IAmf/IAJr/yACb/8gAnP/IAJ3/TwCg/+sAof/rAKL/6wCj/+sApP/rAKX/6wCm/9YAp//aALD/vwCy/9oAs//aALT/2gC1/9oAtv/aALj/2wC5/9MAuv/TALv/0wC8/9MAvf9lAL//XwDB/+kAw//QAMT/2gDG/+kAx/9PAAIACQASABIAAAAkAD0AAQA/AD8AGwBEAF0AHACAAJYANgCYALYATQC4AL8AbADBAMkAdADmAOcAfQAAAAEAAAAA2NdjRAAAAADB4yh0AAAAANnNmRk=') format('truetype');font-display:swap;}*{box-sizing:border-box;}[hidden]{display:none!important;}html{min-height:100%;background:#002e73;color-scheme:dark;}body{margin:0;min-height:100vh;background:linear-gradient(#0065fd,#002e73) fixed;color:#fff;font:17px/1.5 Helvetica,Arial,sans-serif;padding:32px 16px;}button,input,select{font:inherit;}button,select{cursor:pointer;}button:focus-visible,input:focus-visible,select:focus-visible,textarea:focus-visible,a:focus-visible{outline:3px solid #fff344;outline-offset:4px;}h1,h2,.gdfont-Pusab,.gdsButton{font-family:Pusab,Arial,sans-serif;font-weight:normal;paint-order:stroke fill;-webkit-text-stroke:1.5px #000;text-shadow:2px 2px #0006;}h1{font-size:clamp(25px,5vw,38px);line-height:1.2;margin:0;overflow-wrap:anywhere;}h2{font-size:28px;color:#ffc800;line-height:1.25;margin:0 0 18px;}p{margin:12px 0;overflow-wrap:anywhere;}a{color:#fff344;text-underline-offset:4px;}.installer-shell{max-width:650px;margin:auto;}.language-bar{display:flex;justify-content:flex-end;align-items:center;gap:12px;margin:0 0 20px;flex-wrap:wrap;}.language-bar select{width:auto;min-width:150px;}.brownBox{border:20px solid transparent;border-radius:24px;background:#995533;border-image:url('data:image/png;base64,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') 10% round;padding:20px 28px 24px;}.installer-heading{text-align:center;margin-bottom:24px;}.installer-heading p{margin-bottom:0;}.owner-notice{background:#0004;border-radius:8px;padding:14px 16px;margin:20px 0 24px;}.owner-notice strong{color:#fff344;}.owner-notice p{margin:6px 0 0;}.installer-field{margin:0 0 20px;}.installer-field label{display:block;margin-bottom:7px;}.gdsInput{display:block;width:100%;min-height:48px;padding:10px 12px;color:#fff;border:1px solid #ffffff80;background:#0009;border-radius:8px;}.gdsInput:disabled{opacity:.6;}.field-hint{display:block;margin-top:8px;font-size:15px;}.password-control{display:flex;align-items:stretch;gap:8px;}.password-control input{min-width:0;}.password-toggle{flex:none;border:1px solid #ffffff80;border-radius:8px;background:#0006;color:#fff;padding:8px 12px;min-height:48px;}.gdsButton{background:linear-gradient(to bottom right,#c7fc57,#47a20d);border:3px solid #fff;box-shadow:inset 0 0 0 3px #000;border-radius:12px;color:#fff;min-height:52px;padding:8px 24px;font-size:24px;transition:filter .12s;}.gdsButton:hover{filter:brightness(1.1);}.gdsButton:active{filter:brightness(.9);}.gdsButton:disabled{cursor:wait;filter:grayscale(1);}.install-button{display:block;width:100%;margin-top:28px;}.installer-footer{text-align:center;margin:20px 0 0;}.icon-label{display:inline-flex;align-items:center;justify-content:center;gap:10px;min-height:44px;}.installer-icon{width:30px;height:auto;max-height:32px;object-fit:contain;flex-shrink:0;}.installer-checkbox{display:flex;align-items:center;gap:12px;padding:10px 0;min-height:48px;cursor:pointer;}.installer-checkbox input{width:24px;height:24px;flex-shrink:0;margin:0;accent-color:#74c825;}.installer-metadata{display:grid;grid-template-columns:minmax(90px,auto) minmax(0,1fr);gap:8px 20px;}.installer-metadata dt{color:#fff344;}.installer-metadata dd{margin:0;overflow-wrap:anywhere;}.installer-section-title{margin:24px 0 10px;font-size:23px;}.installer-changelog{font:inherit;white-space:pre-wrap;max-height:250px;overflow:auto;margin-top:10px;}.installer-actions{display:flex;flex-wrap:wrap;gap:12px;justify-content:space-between;margin:24px 0 0;}.installer-actions button{flex:1 1 180px;}.installer-progress-heading{display:flex;align-items:center;gap:16px;min-height:80px;}.installer-spinner{width:48px;height:auto;flex-shrink:0;animation:rotate 1.5s linear infinite;}.installer-progress-row{display:flex;align-items:center;gap:12px;margin:20px 0 8px;}.progress-container{--progress:0%;position:relative;min-width:0;width:100%;height:32px;}.progress-track{position:absolute;inset:10px 12px;height:12px;overflow:hidden;border-radius:8px;background:#111;}.progress-bar{height:100%;width:100%;background:url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAAAgCAYAAADaInAlAAABJklEQVR42u2aPQqEMBCFvf95tLEROwsLsVBBFEXERvAHbQTJ7ogHWNjswvjeg+8C4ctkMoljGOg4XAIKwFAAhgI8IPM8Q3IcBwVAFoAVgLufAnD3AwuwbRsk53lSAIYCMBSAgRQgz3NIyrK0J0DTNEYjYRga13Ufhed5HxHHsem67mvSNDWOxqtP27bG931IgiCwto5FUeg8ApIkuSoAIjbLf9/3OgWIoggSKf02s66rPgHqur4qACLTNFldSxkkOez88Tp/tddAaf6kc0XExtxfvQByBiIi5f8XWZZFjwDjOJqqqiDhJPAWAJF93ymAZBgGSPgWcDd/iMigBl4A2QVyBUKEr4HvZFkGiczp4QWQDhh16veP81/lKJjhhxCGAjAUgLGSF/lvXMcqSL6SAAAAAElFTkSuQmCC') repeat-x left center;background-size:auto 100%;clip-path:inset(0 calc(100% - var(--progress)) 0 0);}.progress-contour{position:absolute;inset:0;border:solid transparent;border-width:0 16px;border-image:url('data:image/png;base64,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') 0 32 fill stretch;pointer-events:none;}#progress-bar-text{font-size:22px;min-width:58px;text-align:right;}.installer-stages{padding-left:22px;display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:10px 20px;font-size:15px;}.installer-stages [aria-current=step]{color:#fff344;font-weight:bold;}.installer-open{display:block;text-align:center;text-decoration:none;margin-top:24px;}#logPanel{margin-top:24px;}#supportLog{min-height:110px;resize:vertical;margin:10px 0;font:14px/1.4 monospace;word-break:break-all;}#copyLog{margin-top:12px;}#errorCode{overflow-wrap:anywhere;}.over-flalert,.loading-main{position:fixed;inset:0;z-index:1000;display:flex;justify-content:center;align-items:center;padding:20px;background:#000b;overflow:auto;}.gdalert{border:24px solid transparent;border-radius:24px;background:#001931;border-image:url('data:image/png;base64,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') 65 stretch;width:520px;max-width:100%;max-height:calc(100dvh - 40px);padding:16px;overflow:auto;text-align:center;}.gdalert p{white-space:pre-line;}.gdalert .gdsButton{margin-top:16px;}.loading-main{z-index:1100;flex-direction:column;gap:20px;text-align:center;}.loading-main img{width:72px;height:auto;animation:rotate 1.5s linear infinite;}.loading-main p{font-size:24px;}body.has-overlay{overflow:hidden;}@keyframes rotate{to{transform:rotate(360deg);}}@media(max-width:480px){body{padding:16px 10px;}.brownBox{border-width:14px;padding:18px 12px;}.installer-heading{margin-bottom:20px;}.owner-notice{padding:12px;}.password-control{flex-wrap:wrap;}.password-control input{flex:1 1 150px;}.password-toggle{flex:1 1 auto;}.gdalert{border-width:18px;padding:12px;}}@media(max-width:480px){.installer-metadata{grid-template-columns:minmax(0,1fr);gap:4px;}.installer-metadata dd{margin-bottom:12px;}}@media(prefers-reduced-motion:reduce){*,*::before,*::after{animation:none!important;transition:none!important;}}</style>
    <script>var installerState=<?= json_encode($installerState, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?>;</script>
    <script>window.installerFatal=Boolean(installerState.blocked); window.installerFailureKey=''; (function(){ var handlingFailure=false; function showFailure(messageKey){ if(handlingFailure){ return; } handlingFailure=true; try{ var languageControl=document.getElementById('language'); var language=languageControl?languageControl.value:document.documentElement.lang; var messages=installerState.translations[language]||installerState.translations.en; var errorPanel=document.getElementById('installerError'); window.installerFatal=true; window.installerFailureKey=messageKey==='javascriptUnavailable'?'javascriptUnavailable':'javascriptError'; if(!errorPanel){ document.addEventListener('DOMContentLoaded',function(){ showFailure(window.installerFailureKey); },{once:true}); return; } var message=document.getElementById('installerErrorMessage'); message.textContent=messages[window.installerFailureKey]; message.setAttribute('data-i18n',window.installerFailureKey); document.getElementById('installerErrorTitle').textContent=messages.errorTitle; document.getElementById('installerReload').textContent=messages.reload; errorPanel.hidden=false; var errorCode=document.getElementById('errorCode'); var errorCodeRow=document.getElementById('errorCodeRow'); if(errorCode){ errorCode.textContent='OGDW-JAVASCRIPT'; } if(errorCodeRow){ errorCodeRow.hidden=false; } var loading=document.getElementById('loading-main'); if(loading){ loading.hidden=true; } var form=document.getElementById('installerForm'); if(form){ form.removeAttribute('aria-busy'); } var installButton=document.getElementById('installButton'); if(installButton){ installButton.disabled=true; } var content=document.getElementById('installerContent'); if(content){ content.inert=false; } document.body.classList.remove('has-overlay'); errorPanel.tabIndex=-1; errorPanel.focus(); if(typeof window.CreateFLAlert==='function'){ try{ window.CreateFLAlert(messages.errorTitle,messages[window.installerFailureKey]); }catch(failure){ var overlay=document.getElementById('gd-fancy-box'); if(overlay){ overlay.hidden=true; } if(content){ content.inert=false; } document.body.classList.remove('has-overlay'); } } }finally{ handlingFailure=false; } } window.showInstallerFailure=showFailure; window.addEventListener('error',function(event){ if(event instanceof ErrorEvent||(event.target&&event.target.tagName==='SCRIPT')){ event.preventDefault(); showFailure('javascriptError'); } },true); window.addEventListener('unhandledrejection',function(event){ event.preventDefault(); showFailure('javascriptError'); }); document.addEventListener('DOMContentLoaded',function(){ if(!window.installerInitialized){ showFailure(window.installerFailureKey||'javascriptUnavailable'); } var form=document.getElementById('installerForm'); if(form){ form.addEventListener('submit',function(event){ if(window.installerFatal){ event.preventDefault(); } },true); } }); })();</script>
</head>
<body>
    <main class="installer-shell" id="installerContent">
        <div class="language-bar">
            <label class="icon-label" for="language">
                <svg class="installer-icon" aria-hidden="true" viewBox="0 0 36 32" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 7h18M12 3v4M7 10c2 7 7 11 13 13M18 7c-1 8-7 14-14 17M21 29l6-16 6 16M23 24h8"/>
                </svg>
                <span data-i18n="language"><?= $escape($messages['language']) ?></span>
            </label>
            <select class="gdsInput" id="language" name="lang" form="languageForm">
                <option value="en" lang="en" <?= $language === 'en' ? 'selected' : '' ?>>English</option>
                <option value="es" lang="es" <?= $language === 'es' ? 'selected' : '' ?>>Español</option>
                <option value="ru" lang="ru" <?= $language === 'ru' ? 'selected' : '' ?>>Русский</option>
            </select>
            <noscript>
                <form id="languageForm" method="get"><button class="gdsButton" type="submit">OK</button></form>
            </noscript>
        </div>
        <section class="brownBox" aria-labelledby="installerTitle">
            <header class="installer-heading">
                <h1 id="installerTitle" data-i18n="<?= $titleKey ?>"><?= $escape($messages[$titleKey]) ?></h1>
                <p id="installerSubtitle" data-i18n="<?= $view['authenticated'] ? 'selectionHint' : 'subtitle' ?>"><?= $escape($messages[$view['authenticated'] ? 'selectionHint' : 'subtitle']) ?></p>
            </header>
            <aside class="owner-notice" id="ownerNotice" <?= $view['authenticated'] ? 'hidden' : '' ?>>
                <strong data-i18n="ownerTitle"><?= $escape($messages['ownerTitle']) ?></strong>
                <p data-i18n="ownerDescription"><?= $escape($messages['ownerDescription']) ?></p>
            </aside>
            <aside class="owner-notice" id="installerError" role="alert" <?= $errorKey ? '' : 'hidden' ?>>
                <strong id="installerErrorTitle" data-i18n="errorTitle"><?= $escape($messages['errorTitle']) ?></strong>
                <p id="installerErrorMessage" <?= $errorKey ? 'data-i18n="' . $escape($errorKey) . '"' : '' ?>><?= $errorKey ? $escape($messages[$errorKey]) : '' ?></p>
                <p id="errorCodeRow" <?= $view['code'] ? '' : 'hidden' ?>><span data-i18n="errorCode"><?= $escape($messages['errorCode']) ?></span>: <code id="errorCode"><?= $escape($view['code']) ?></code></p>
                <a id="installerReload" href="<?= $escape($_SERVER['SCRIPT_NAME']) ?>?lang=<?= $language ?>" data-i18n="reload"><?= $escape($messages['reload']) ?></a>
            </aside>
            <form id="installerForm" action="<?= $escape($_SERVER['SCRIPT_NAME']) ?>" method="post" aria-describedby="ownerNotice" <?= $view['authenticated'] ? 'hidden' : '' ?>>
                <input type="hidden" name="action" value="login">
                <input type="hidden" name="csrf" value="<?= $escape($view['csrf']) ?>">
                <input type="hidden" name="lang" id="installerLanguage" value="<?= $language ?>">
                <div class="installer-field">
                    <label for="userName" data-i18n="userName"><?= $escape($messages['userName']) ?></label>
                    <input class="gdsInput" type="text" id="userName" name="userName" autocomplete="username" autocapitalize="none" spellcheck="false" required>
                </div>
                <div class="installer-field">
                    <label for="password" data-i18n="password"><?= $escape($messages['password']) ?></label>
                    <div class="password-control">
                        <input class="gdsInput" type="password" id="password" name="password" autocomplete="current-password" required>
                        <button class="password-toggle" id="passwordToggle" type="button" aria-controls="password" aria-pressed="false" data-i18n="showPassword"><?= $escape($messages['showPassword']) ?></button>
                    </div>
                </div>
                <?php if (!$view['connectionExists']) { ?>
                    <div class="installer-field">
                        <label for="conn" data-i18n="connection"><?= $escape($messages['connection']) ?></label>
                        <input class="gdsInput" type="text" id="conn" name="conn" value="<?= $escape($view['connectionFolder']) ?>" spellcheck="false" aria-describedby="connectionHint" required>
                        <small class="field-hint" id="connectionHint" data-i18n="connectionHint"><?= $escape($messages['connectionHint']) ?></small>
                    </div>
                <?php } ?>
                <button class="gdsButton install-button" id="installButton" type="submit" data-i18n="signIn" <?= $view['blocked'] ? 'disabled' : '' ?>><?= $escape($messages['signIn']) ?></button>
            </form>
            <form id="selectionForm" <?= !$view['authenticated'] || $view['job'] ? 'hidden' : '' ?>>
                <div class="installer-field">
                    <label for="branch" data-i18n="branch"><?= $escape($messages['branch']) ?></label>
                    <select class="gdsInput" id="branch" name="branch">
                        <option value="stable" data-i18n="stableBranch"><?= $escape($messages['stableBranch']) ?></option>
                        <option value="prerelease" data-i18n="betaBranch"><?= $escape($messages['betaBranch']) ?></option>
                        <option value="master" data-i18n="masterBranch"><?= $escape($messages['masterBranch']) ?></option>
                    </select>
                </div>
                <p class="owner-notice" id="branchWarning" hidden></p>
                <div id="customPathOption" <?= $view['allowCustom'] ? '' : 'hidden' ?>>
                    <label class="installer-checkbox" for="customPath"><input type="checkbox" id="customPath"><span data-i18n="customPath"><?= $escape($messages['customPath']) ?></span></label>
                    <div class="installer-field" id="customPathFields" hidden>
                        <label for="target" data-i18n="target"><?= $escape($messages['target']) ?></label>
                        <input class="gdsInput" id="target" value="browser" spellcheck="false" aria-describedby="targetHint">
                        <small class="field-hint" id="targetHint" data-i18n="targetHint"><?= $escape($messages['targetHint']) ?></small>
                        <p class="owner-notice" data-i18n="manualWarning"><?= $escape($messages['manualWarning']) ?></p>
                    </div>
                </div>
                <button class="gdsButton install-button" id="reviewButton" type="submit" data-i18n="review"><?= $escape($messages['review']) ?></button>
            </form>
            <section id="reviewPanel" hidden aria-labelledby="reviewTitle">
                <h2 id="reviewTitle" data-i18n="confirmation"><?= $escape($messages['confirmation']) ?></h2>
                <dl class="installer-metadata">
                    <dt data-i18n="version"><?= $escape($messages['version']) ?></dt><dd id="planVersion"></dd>
                    <dt data-i18n="downloadSize"><?= $escape($messages['downloadSize']) ?></dt><dd id="planSize"></dd>
                    <dt data-i18n="unpackedSize"><?= $escape($messages['unpackedSize']) ?></dt><dd id="planUnpacked"></dd>
                    <dt data-i18n="target"><?= $escape($messages['target']) ?></dt><dd id="planTarget"></dd>
                </dl>
                <p class="field-hint" id="planVerification"></p>
                <h2 class="installer-section-title" data-i18n="changes"><?= $escape($messages['changes']) ?></h2>
                <pre class="owner-notice installer-changelog" id="planChanges"></pre>
                <p class="owner-notice" id="planManualWarning" data-i18n="manualWarning" hidden><?= $escape($messages['manualWarning']) ?></p>
                <label class="installer-checkbox" for="confirmInstallation"><input type="checkbox" id="confirmInstallation"><span data-i18n="confirmationText"><?= $escape($messages['confirmationText']) ?></span></label>
                <div class="installer-actions">
                    <button class="password-toggle" id="backSelection" type="button" data-i18n="backSelection"><?= $escape($messages['backSelection']) ?></button>
                    <button class="gdsButton" id="confirmButton" type="button" data-i18n="confirmInstall" disabled><?= $escape($messages['confirmInstall']) ?></button>
                </div>
            </section>
            <section id="progressPanel" hidden aria-labelledby="progressTitle">
                <h2 id="progressTitle" data-i18n="progressTitle"><?= $escape($messages['progressTitle']) ?></h2>
                <div class="installer-progress-heading"><img class="installer-spinner" id="progressSpinner" src="data:image/png;base64,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" alt="" width="48" height="48"><p id="progressStage" role="status" aria-live="polite"></p></div>
                <div id="div-progress-bar" class="installer-progress-row">
                    <div class="progress-container" id="installerProgress" role="progressbar" aria-label="<?= $escape($messages['progressTitle']) ?>" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-track"><div class="progress-bar" id="progress-bar-img"></div></div>
                        <div class="progress-contour"></div>
                    </div>
                    <span class="gdfont-Pusab" id="progress-bar-text">0%</span>
                </div>
                <p class="field-hint" id="downloadBytes"></p>
                <ol class="installer-stages">
                    <?php foreach (['downloading', 'verifying', 'extracting', 'placing', 'finalizing'] as $progressStage) { ?>
                        <li data-stage="<?= $progressStage ?>" data-i18n="<?= $progressStage ?>"><?= $escape($messages[$progressStage]) ?></li>
                    <?php } ?>
                </ol>
                <p class="owner-notice" id="notCancelable" data-i18n="notCancelable"><?= $escape($messages['notCancelable']) ?></p>
                <a class="gdsButton installer-open" id="openBrowser" data-i18n="openBrowser" hidden><?= $escape($messages['openBrowser']) ?></a>
            </section>
            <section id="logPanel" <?= $view['log'] ? '' : 'hidden' ?>>
                <label for="supportLog" data-i18n="logLabel"><?= $escape($messages['logLabel']) ?></label>
                <textarea class="gdsInput" id="supportLog" readonly rows="4"><?= $escape($view['log']) ?></textarea>
                <small class="field-hint" data-i18n="logHint"><?= $escape($messages['logHint']) ?></small>
                <button class="password-toggle" id="copyLog" type="button" data-i18n="copyLog"><?= $escape($messages['copyLog']) ?></button>
                <p id="copyLogStatus" role="status"></p>
            </section>
            <noscript><p class="owner-notice" data-i18n="requiresJavascript"><?= $escape($messages['requiresJavascript']) ?></p></noscript>
            <footer class="installer-footer">
                <a class="icon-label" href="https://discord.gg/EbYKSHh95B" target="_blank" rel="noopener noreferrer"><img class="installer-icon" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAAB6CAYAAAB3N1u0AAAAAXNSR0IArs4c6QAAF/JJREFUeF7tXQl0FVWa/h6EEBIgkUVAwIR2QVBJcBsUJcFlOLYoONO4HVqge+xWe5CMrTZRu0GZ0zJz7CbpxW1sCXradmgUaE7jOYgCgtCLA6GDCigkEJDIIkGykYTU8NWreq/WV3Wr6r28R3LPeYfw3l3//7v/dv+6FUJX6dQUCHXq1XctHl0A6OQgSCgAJEkqBJDHjyRJRVrah0KhAgA5nYQfFZIk1alrDYVCFQD4//UAKkKh0IlE0SHuAJAkacaZRU09szgyvMMYLAGpJO4IiBVn6FUabzDEBQBNkpSbAcw8g+rijmS6q12U5Mg4ffr065IkLe7RowelQ+AlUABIkpR9ZobzFcYLTbaiogJ1dRGpKNQ21SoXFBQgJ0dMGDY3N6+uqqpaMHr06I8BtAW15sAAIEnSlDO6vdxux1dXV2P9+vUgo9XPiRMJU3X+6UVKUVrEoeTn5yMvLw8ERlFRkfyxKzU1NaXnn3/+MwCaALT4nZVvAMi7XpJWIBSynPWKFSvAz5IlS+JAOmOXfrjkp22wS8vNzcXMmTNRXFxsKSmam5sPLV68+OGHH374IwDf+AGCLwBIkpSv7Hpa8LpCps8pLsb+ffuCpU4n623GjBkoLS2VgaA1V1pbW+uXLl26cPr06W8D+EoBwmlR8ngGgMJ8GiY6ZUbxTvRu3749PJfk2ViitEmq+vPmzcP8+TSv9GXZsmWLpk2b9kcANQCOAjglohY8AYBiX5Ik+qv06SOlvLxcFltudXt2/1zkDAh30b1HuJvzRhSgV1YO9uzQG71NDXU4VKWAKqlYk7jJFBYWyurUaEC++uqrCx544AGqgwMKEOoBtLuZmTAAFEuf3NGJfTK+rKws5pijrp6CC8cUyUy+4HJ7Q8fNxFO5zp5KPbiPH64GPwT93h0bYi6N9gFBQINRWxRJ8B6AWgDUu3SpHEHgBQDLlcBOZHyKfDsjr2evbPzzffNx1Y0z0au3mOuTykz2M3cC5JO/rsCmVdYbKjs7W/aojCAoLi6eXVZWVgXgMIA9bkAgBABJkuYwOmUU+7NmzTKtN71nNm65dz4K72QsqKt4oUBTfR02rSrFe2/R61OKYlMZQUADsa21tf6ee+6Z/c477xxRJAHBEFMSuAaAYvQxRKnT+VbMP3foGHxv3kr0G6QzEbzQIM5tkjwMqKz+y70VWPLcVBw/rPeoCAIa3YwhqKW2trZyyJAhJcr/KQk+B8CAi2UUwzUA2tvbq7RGHwdmwMJo8F1w6e344c//ZMu4xhPtOHmsDU0n2tHSFFVR9V8LezBxBkf8u0/PCCE9s1tkoD79uyOjb3f06Z+GtHR+HQUopQFBYLQRGEQiLyzsgfeV7/YD2AugwWpFrgBgFP0M2ZL5EVdP6bn/4DH4yctmS/1Uo4TDVS04ur8FUufjsyckZfTphkHfSkf/4Yp7xNBffR1eerrI5A3NmTNHjhWohTGCK6+88nuVlZWNiiG4FxeiGl/ILqKuOAJAsfqrtf6+lcVPnf/Ua9U6Q6+tBTjwSTO+PtjqiQhdjYBQdyCvoBfOGZwmx1RoIL789EQTabZt26YzCjdv3vz78ePH/0GpyLDxTsUu0HkGbgAw70wnkQgErc+JE80TuO/Rd1BQeGdkYscPtaG6osl+x8dJ/SZV3CnANVIiXHxtlqwaXnqqyKQKGCNYv35d5NDbIAXIF0YLdysRwwifHAFg1P0U/Rs26H3VYRdMwCO/jH5XvS2xu16E6ZZ1A2RUMFLLekWUBiOvy0LdsX+g9D/GmoZavnw5pk5l6kW4GKQAd/4uALQJIqeJMQGgnPAxMUEudrv//pLluGxceOBDu07h0Oc8pHIqImxz6svn78kAANVGd9iSBMHlN/XBr58oMNkCYSkQDTI1NjZ+lZWV9X0Ndb4G8JniGspfOwFgMcKJHXKxCvj07ZeLpxfTRACO1bRi3/Zmn9ywbp5EcInL+kQ6pTo42fxHvP2COf5itAU0wSEOYZICTgA4rjX+QqGQ6WznutvmYOoPSkH3budGS09DZG0pVLeDIZl+EG/9dpSJXkaPYM2aNa9MmjRJ65cfU6SAnIxhCwBj4Ifx5zvvjBp56sg//M91yB1ZhJ0f1qOlOU4ZE4mChaoKkkEluFjz8jeG41SzPqmGZwVMvlGLITDEr6n/K6mtGWiIBQBd2Ncu3v/fKyUBve9iVVZVUoQhHlfnudkHf/42Dn+5ydS+qqpKFx0MhUKTDZUYHSRKWmIBQKf/efBgDPzwoOfp147jkw94+thJShKBceuWn2D3jhdNhDd6AwY7gPXpEtIjOGkLgPb29nUhTZoX9b+x5AzMxX0/2pkCgZ4O1teB7Q39Onb833PYsfU5U+/G5JGFCxfOLSkp2aGpyMAQ1cCRWBIgYgBSp4wYMcI00LcuL8Q/jV8Vh/BuxzEsOnJwcwiuJz0L7ADANDIm56jFwhDkT/9gAkksAEQsOjv/f8IdP8N5gx4LDN92HcWLgPGZeAJmq6ihw19uxAd/vs20DGM8wBAQUutTBezzBAB1ieNueRp5eU9oJpCAxceHa3Hq1YkeTr/HnpY7AEjYvHmL9lxA7ZQnhHs9AUDt4YrxT+Li0XPjRDyxbkdd3B2jR3aXG729yk0kUqz/84d1w9Vj03DkaDv21bRj3wHHbCuxATzUlgGw+jbTSX/hhEKs3xCNCNpIgIPMFfAFgPxrSjAqX809cLsCf6jnKJm9gNzh3XFVQRryhnfD6JFpusFfXNyED7cE9vCM3PdPf9xLNw6BUF1zGh9XtAkCwsX6XXoa7iSA6UxApRVzB3f7AsBlV5TgsitFAeAWKPp6A/qHMPriMNOvHhs9I7fqjcx55MngopKULj97LFM/lIFJHPPT3WFA8OOvuAAJE//82QDJDwDudO5uMp2frEyHkxIN1YOUAsbd78RcguHvFW34cHNrXFXFWQsA7vbC63qg8NoeGDggmjLlRHjt76p4DquMkKwq5L8z+XfYVtCWhkYJ+2rC6Ury34qOZ9tv3yznZ3kqn+5qw7vvtwYgFczDxxcA7ZKknhTYuYHxUAETrk3D/XdnCO12T5zx2silfjZ2T0AueL4RjQzBBFTiCwBJcowDiAHAWa9x5y/8aVaCmS+BSHevXLxzb9mqU4F6KCkGAAvC8SwqFD1BtNe1Hredbsgg+vDOfLXls8834rPd7jNjY20b1wD4aPPvx1+v5AdS+4WHTy4jkEbejx/uJUDh5GCowITlqlQFJQuYrOtQXCzPNQD0CaLqwG4AEJ5FvG0AWvsU/V4NPidaCv/ugvjCfWoavP6/zbJh6Le4BoBWAsiDymLADQDCU4w3AB6cmSFb/Z2l0Mt4pKTet0F4+KASCTQQzuVZQHIAgIbfr57rnRAjLJkAtmFzK14q95c/6VoCeFcB4TDzBptnAcS8AGvyiwZZEslEW00QkIqYXVKPo8e8p9ElBADxVAGWIdZAOBwQhzzMRWRkv1Ig5QHQkbtfhFHOOPDe29xnGzyHi1MHABb00e5+7+RzZk2y1/AjBVIHABZcePShDMdTveRknghc3dX1agukLABo+f/6ud6C/HVHTMFOk6K6VymQsgD47l09fZ2wiXMtucHjNS6QsgB4tbR3gg983EHGNUxcV3Q3Lmt5yV9ISQDwuPehWSIxf/dE9FvTyNc48Nl2iswbWPALi7PiGJMQBUD0HEieRpwjgTYTj5vxFxi3AutIGI+ixqAoAAwTqh0Qv5xA7SFm9G9vxp8wHVO2weq1LXhjqekaH9v1+AVAIEmhl19Z4voW9djiv+N2XrIgxvVRsTLhpACASFawkPg/K/AgvojZT9bj6FF35wMpB4A/vNJHs9n8m1zcMe+ubcERw4EKk0v8JHIaJUKixuG4IrkCbgBAKm/xcxoY1GFQ0Ac/Tvl1ucO64cFZGZYZwCIiP1HjqHP6+7ZW/PJFd8fEbgDAfm2eDPLnBdC0u5QPhlxR4up1XP96ezq+c3tPEdrb1nVrLHlKMtUIpriOY7M6BoX+rdjdfQueANBROYGeT/4MmkL0qR/HuIONmg58HAHouz0h9ASA6Dz8SQD2I5IQIhz9s2GMl4jZr34unm+YqHGscOHWDkgZAATp/9/7g5Mamjk/a8DKlurHwUDXj+Nu+wal5tweDiUAAGEq+U0KFU/5tia4bbjUgT+iBmiixrGbttt4QAIAEJ6iXwB43RnGTZooxiRqnDB1rUWRUQJZybqUAUBQad/eGdMNP3ssy50cB+B9HIvHyF2Pqq/o5lwgZQDg2QMwEE/UMlc32ITrxE4gPY0DwNHjEACDm0fI4gqAdkmK3CLpVwV4scLtaOVmZxjbepFAiRrHcp0S8PpS56eH4goAKcCng/UhYIFtYFHVKTJnbMLHzvjgicjlEuwjUePYWQFuxk8dALzcx1W00A00GCmbu6BB90BFLGfQa/qZ1Tix5ud1HLs+3UQhUwIAoi6YGxDQTXppcbNjPr1X70OdQ6LGsVqzG0O00wKABOMO/cULTfhsN69r0x+fUuzzlpEgHjiNjmN+pp/Xx9x/d89AxjGCQBgAGjGYVA+HxkMCaIlFi33Dluij1mQKGS+q850kDxnCW8DUMrB/t0AYbxeQFAaAZgGdCgAmxonnYDjwPvAOnbAm/y4D4PmmmLZTiqgAsSCMK+p0gkr+JMAErF8ffYlXXPIByAM3p4GxVEBkb3XMJktqGPkDgP7lUQkGgN4pE7IBuoAQAWUKA0C/sYQAILwnPSDGQxPhaQXQoAsAARAx0kWKMF275C4ABAmAFOzrrAEAgzK/K9Omg3vnBjNmeYdv+Jp4832/3nt2bhlLiDQ0Ah9XtOLIsXbcelN6IDEIt1lBb/1PX9PkExYHuPyKElzq4rr4IE4DyXzeqqXetUvb4ju3p5veFeDEyiC1gRqE4rMJ6rxuvamHHIX0W9zmJHYoAM4dcj1unLza1VqDOCxhWJYJk9qXQajvEbj15vSESAXO4d33W/DprtO6K1+tn0MQhxtB9WJ5s+vrZDseALetdn3SR9F9/109fd8ISiLxuJQvZtDevq2+SYSvjuHLJfhWEb8hYeriar4ipua0HAo2XutGxhN80XMHcaarO4hinwAXuVG84wHgUgKoiySTSLAgHhLhbiTRYj1RSwnBuD3fF8B3BbgpfCcQ+451qXMQTx6pUCGgX18aBrRoSTkAqAskYygNnF7/4kQQN4kTTn14+d1rool2LFWdaG0I0bkkHQD0cUDnvH2vxhwJ5fVuHVEi29X3lm8Q3veUXASvn5tCOa8OB8BNk1e7vh8gFuG9AMGtpRwUw636EfVwYjLeg/nQsQAYfD1uvN2dF+CWCQQCXSkn1eAmUOJ2TD/13Ia6g9rxxrnGHQAEpd1l0WE38F1TRo4fgmptBBqKtOYHDqAqiRpwovl6QcwnVh9RF1e/hdV7BYJ+h6F2LnEHAAezSwsXiQP4YcJV+Wm4amxaxNVy+/CknzFF2mpfeEGmM0bAWIFf/e5sQfmzARwviQrjWZKTCyZOnGiiSaIAoB2YIlfknTsijPRTl14NizjT3bDZfmaJlQCGuXYEAPww6WxsmxAAVFRUYOzYsZb0u+eBb85GusZ9Tf72fXR6OgAonU6ZMgUrVqyIVPKUEdTe3r4uFAoVqb2EQtZRtH+5fz/Se+bEnWBdA5gpYJcUOm/ePMyfPz/SYOHChXNLSkp2GHqIfUOIEQA5OTk4ceKEaRY337EWAwZd08UfUsCDH++HcHYAWLRoEYqLi/0B4MyzgfPO9BCBUVFRETZs2CA7Y9rHMK6d+DsMGlqIjF7n+lmLx7ZBCVKPw3dws12VL2DbX+aaZrFu3TqQXxrpPdliqgcAfBHr9fFTAKxQUU2R8swzz5j6GTvuv5DdbxQGD40OGBxdkoTBMXZ2dIZe5uqlTZS6f13/IKo+f9NEbs1zvWhsbPwqKyvr+xY8+ZzvsYwFgFxWUBvaGYIjL/sR+g28Atn9RiOn36XB8f5s6ylg9dB+ugWr3roMTY1U5dFiNAB37969duTIkaVmcvbcCZzaF/N8VJKkbWekQIHaOC8vD/v27dP1NWDwdbhoVBhgQ4bfYmkQ+sP52YaEYNZTU7USH639rqmzxYsXY+bMmZHvly1btmjatGnvGyrygcoKAIecADAHQAQ9NCzKysp0fXVP64VrbviN/F2oWw9ZFXR5BcEw2a6Xo1/9DTu2LkTtgbWmKsePHwcNdrWMGTPmrsrKSsPLitMagTZ6BUecAKBTA9XV1RgxYoRp0LwL75F3v1r6n3s1evfNiy8VhHu3lkPJL52iM6TYrz24Hq0tJ/C3jf+O021NOqN8xowZKC8vj1DGXvzjMIBdAL5xTJExuoMUL0uWLDFIgQxcc8Nvdd8lJwiEUZM0DbTMP3zoI+zZ+ZppblVVVaCaVouN/8+f9wCoAnDKEQCSJBXyPEjt1E4KDMu7A8NH0HGIlqw+ueg3oADduqcnDSFTcSItp+pApp9ua0RbayO2/uUJefdri3H319XV7T3nnHMesVgvn6WvpP6X1bYbghilgJ1LOLrgcWSfc4muS9oFBEFm1nlnARASq0baWhtQ9/UnaDgZNbx3Vv4Gx4/SNo+W7OxscGNqdb+N8cdGcgQQgHzlqisAGKUAGxYUFGD79u0GVdALlxY8gaw+55twRSD07pOHvjkXIa2H+zv7rAGa/Jrbzcayq9NYfxD1J6vR1PClrsqhmvdQ/cVbpmbLly/H1KlTI9/X1tZWDhkypMSif1r/OwHUAJAzUF0BgBUlSVoEIBJfZFyA0SZjeLhHel+Myn8UWb2H29KAnkNm1jB0697Dpk7ATrMHbhghlgjIUdQ3Nx2B1B698USdOt2+A9V/Mq3EKPpZobi4eHZZWRl1vLEwlv8pgK/VH0QAkK3YApG4AC3OWbNmWZJ38LCbMeKiez2QvquJlgLU+V/sfM0k9lknPz8f3IjaYnPyxyq832YvAOqTyJupXANAkQL5CggijiaPHRkfMAaIWL9nRn8My5uCc4eMjwtXO15OxGVZcqdkfE31ShyppfFnfp8gmc9MLa3ejyH62eVRRfzrTvSEAKCAIHxGoCl1dXWyOjDaBGoVAmHg4PHoN2CsyT7oeCZ2/Ay0tGw4uR+Haz+Sd/yp5mOWCLMS+4z5jxs3brY56CN3wR1Pv59Ghe66M2EAKCCYASAacTijd5xAoK6E+r9vziURG6FnxgBZUsQqaWmZloZl/Paft57JvLY2fdCNTDzVzM0XLfy/kblW31nNYs6cOSgt1Yf2W1tb6x9//PESG71Phu9X/H6TKPEEAAUEujAxvyMIqA7kQJHGakqEAeWNZYoZrL9m0HNX8WxIV482l9ba53gOzKfVf0Rx+yxTtzwDwE4S8HvqJkYMreyCwIhkhyrD9/7B578Hv2vmrufG0kb5lA23d8KECXNtxD5hTX1P0a8XQZoJ+QJALBBQGhCxFFdxBYJhMfJmjgPP4tClIy540QPpx5iLsezfv3/L5MmTF8VgPgM9DPl+ZdT72r58A0ABgclFVAepqzsup5UTDCtXrnRcdGevkJubK4t5qx2v0mbNmjWvTJo0SRMU0L0XnGKf4p4uHw99zHfcBikBtAwzBouMzKRUoHqg78p/u0qYAhTt3OX0pKx2e3Qz1e2dP3/+Ihtjj9UY3fsafbEH30SDPbHoHIgEMIAgt62t7Y20tLQbuhgcDAXo4m3atGmlftcb+k5DM9pkg4+BHnP2rs1UAgeAOk5TU1NefX39Uzk5OXenpaUFc0tUMPTs0F5Eog480Vu7du3KZ599douNrudaKPLpex4EwERPd++dVagQNwBoqNx/48aNDw0dOnT8oEGDxmZmZg7qUA4k+eBkenV1dWV5eflarajXafnwGsj4FnrfyuEOo0Yx9b3V0hMBAI6bBmAwgEHTp0+/YOLEiaMvueSSC00TEtkeScNI/5Our69v2Lp1694333xzb4ydrq6YjOcu5wuGKfJ5vCu067WkSxQA1DEJhH4ABgKg58C3STNbhAD3OReLPaKMav9L0qDIaSJkOo8IGdJVGc8dbz4kcOrJ8LtPoguOpq9Ou4CHSrzpkAkCPBsmQLr56tVzYw4tfkmT8HDuh6FooUjnpMho+vU8xqWLJyzq7ebZkQDQzolk6QUgUwGBMF0T2YATNW09yy99zYpM5o5vUHS9r87sGv8/hC/h1XpUfRUAAAAASUVORK5CYII=" alt="" width="32" height="32"><span data-i18n="support"><?= $escape($messages['support']) ?></span></a>
            </footer>
        </section>
    </main>
    <div class="over-flalert" id="gd-fancy-box" hidden>
        <section class="gdalert fancy-box" role="alertdialog" aria-modal="true" aria-labelledby="fllayertitle-fancy" aria-describedby="fllayerdesc-fancy">
            <h2 id="fllayertitle-fancy"></h2>
            <p id="fllayerdesc-fancy"></p>
            <a class="icon-label" href="https://discord.gg/EbYKSHh95B" target="_blank" rel="noopener noreferrer"><img class="installer-icon" src="data:image/png;base64,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" alt="" width="32" height="32"><span data-i18n="support"><?= $escape($messages['support']) ?></span></a>
            <div><button class="gdsButton" id="gdclose-fancy-btn" type="button" data-i18n="ok"><?= $escape($messages['ok']) ?></button></div>
        </section>
    </div>
    <div class="loading-main" id="loading-main" hidden>
        <img src="data:image/png;base64,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" alt="" width="72" height="72">
        <p class="gdfont-Pusab" id="loading-alert-buttom-display-text" role="status" aria-live="polite" data-i18n="fetching"><?= $escape($messages['fetching']) ?></p>
    </div>
    <script>const installerForm=document.getElementById('installerForm'),languageSelect=document.getElementById('language'),alertOverlay=document.getElementById('gd-fancy-box'),loadingOverlay=document.getElementById('loading-main'),passwordInput=document.getElementById('password'),passwordToggle=document.getElementById('passwordToggle'),selectionForm=document.getElementById('selectionForm'),reviewPanel=document.getElementById('reviewPanel'),progressPanel=document.getElementById('progressPanel'); const installerEndpoint=new URL(installerForm.getAttribute('action'),location.href).href; if(new URL(installerEndpoint).origin!==location.origin){ throw new Error('Invalid installer endpoint'); } let previousFocus=null,currentAlert=installerState.alert,currentPlan=null,currentStage='',currentPercent=0,pollTimer=null,pollCount=0,isBusy=false; window.installerAccepted=Boolean(installerState.job); window.installerRunning=Boolean(installerState.job&&installerState.job.status==='running'); function translate(key){ return installerState.translations[languageSelect.value][key]||key; } function megabytes(bytes){ return new Intl.NumberFormat(languageSelect.value,{minimumFractionDigits:2,maximumFractionDigits:3}).format(Math.max(0,bytes)/1048576); } function setTextKey(element,key){ element.dataset.i18n=key; element.textContent=translate(key); } function updateLanguage(){ document.documentElement.lang=languageSelect.value; document.getElementById('installerLanguage').value=languageSelect.value; document.querySelectorAll('[data-i18n]').forEach(element=>{ element.textContent=translate(element.dataset.i18n); }); passwordToggle.textContent=translate(passwordInput.type==='password'?'showPassword':'hidePassword'); installerForm.querySelectorAll('input').forEach(input=>{ input.setCustomValidity(''); }); const reloadUrl=new URL(document.getElementById('installerReload').href); reloadUrl.searchParams.set('lang',languageSelect.value); document.getElementById('installerReload').href=reloadUrl.href; const locationUrl=new URL(window.location.href); locationUrl.searchParams.set('lang',languageSelect.value); history.replaceState(null,'',locationUrl); updateBranchWarning(); if(currentPlan){ fillPlan(); } if(currentAlert){ renderInstallerAlert(); } if(currentStage){ document.getElementById('progressStage').textContent=translate(currentStage); } } function CreateFLAlert(title,description){ if(alertOverlay.hidden){ previousFocus=document.activeElement; } document.getElementById('fllayertitle-fancy').textContent=title; document.getElementById('fllayerdesc-fancy').textContent=description; alertOverlay.hidden=false; document.getElementById('installerContent').inert=true; document.body.classList.add('has-overlay'); document.getElementById('gdclose-fancy-btn').focus(); } function closeFLAlert(){ alertOverlay.hidden=true; currentAlert=0; document.getElementById('installerContent').inert=false; document.body.classList.remove('has-overlay'); if(previousFocus&&previousFocus.isConnected){ previousFocus.focus(); } } function renderInstallerAlert(){ const key=window.installerFailureKey||installerState.alertKeys[currentAlert]; if(key){ CreateFLAlert(translate('errorTitle'),translate(key)); } } function changeLoadingAlert(message=translate('fetching')){ document.getElementById('loading-alert-buttom-display-text').textContent=message; } function finishLoadingAlert(){ loadingOverlay.hidden=true; installerForm.removeAttribute('aria-busy'); document.getElementById('installButton').disabled=window.installerFatal; document.getElementById('installerContent').inert=!alertOverlay.hidden; document.body.classList.toggle('has-overlay',!alertOverlay.hidden); isBusy=false; } function startLoading(message){ isBusy=true; changeLoadingAlert(message); loadingOverlay.hidden=false; installerForm.setAttribute('aria-busy','true'); document.getElementById('installButton').disabled=true; document.getElementById('installerContent').inert=true; document.body.classList.add('has-overlay'); } function displayError(error){ finishLoadingAlert(); const key=Object.hasOwn(installerState.translations.en,error.messageKey)?error.messageKey:'serverError'; window.installerFatal=Boolean(error.blocked||window.installerAccepted); if(error.status==='error'){ window.installerRunning=false; languageSelect.disabled=false; document.getElementById('notCancelable').hidden=true; document.querySelectorAll('.installer-stages [aria-current]').forEach(element=>{ element.removeAttribute('aria-current'); }); } setTextKey(document.getElementById('installerErrorMessage'),key); document.getElementById('installerError').hidden=false; document.getElementById('errorCodeRow').hidden=false; document.getElementById('errorCode').textContent=/^OGDW-[A-Z0-9-]{2,70}$/.test(error.code)?error.code:'OGDW-CLIENT-RESPONSE'; document.getElementById('progressSpinner').hidden=true; if(!progressPanel.hidden){ currentStage='errorTitle'; setTextKey(document.getElementById('progressStage'),'errorTitle'); } if(typeof error.log==='string'&&/^[A-Za-z0-9+/=]*$/.test(error.log)&&error.log.length<65536){ document.getElementById('supportLog').value=error.log; document.getElementById('logPanel').hidden=!error.log; } document.getElementById('installButton').disabled=window.installerFatal; document.getElementById('reviewButton').disabled=window.installerFatal; document.getElementById('confirmButton').disabled=window.installerFatal||!document.getElementById('confirmInstallation').checked; CreateFLAlert(translate('errorTitle'),translate(key)); } async function request(action,values={}){ const body=new URLSearchParams({action,api:'1',csrf:installerState.csrf,lang:languageSelect.value,...values}); let response; try{ response=await fetch(installerEndpoint,{method:'POST',body,credentials:'same-origin',headers:{Accept:'application/json'}}); }catch(failure){ throw {messageKey:'streamError',code:'OGDW-CONNECTION',blocked:false}; } let data; try{ data=await response.json(); }catch(failure){ throw {messageKey:'serverError',code:'OGDW-HTTP-'+response.status,blocked:true}; } if(!response.ok||data.ok!==true){ throw data; } return data; } function showSelection(repair,allowCustom){ installerState.authenticated=true; installerState.repair=repair; installerState.allowCustom=allowCustom; setTextKey(document.getElementById('installerTitle'),repair?'repairTitle':'title'); setTextKey(document.getElementById('installerSubtitle'),'selectionHint'); document.getElementById('ownerNotice').hidden=true; document.getElementById('customPathOption').hidden=!allowCustom; document.getElementById('installerError').hidden=true; document.getElementById('logPanel').hidden=true; installerForm.hidden=true; selectionForm.hidden=false; reviewPanel.hidden=true; document.getElementById('branch').focus(); } async function submitForm(event){ if(event){ event.preventDefault(); } if(isBusy||window.installerFatal||window.installerAccepted){ return false; } if(!installerForm.reportValidity()){ return false; } if(!document.getElementById('userName').value.trim()||!passwordInput.value.trim()){ displayError({messageKey:'credentialsError',code:'OGDW-AUTH-INPUT',blocked:false}); return false; } startLoading(translate('signIn')); try{ const values=Object.fromEntries(new FormData(installerForm)); const result=await request('login',values); passwordInput.value=''; finishLoadingAlert(); showSelection(result.repair,result.allowCustom); }catch(error){ displayError(error); } return false; } function updateBranchWarning(){ const value=document.getElementById('branch').value; const warning=document.getElementById('branchWarning'); warning.hidden=value==='stable'; warning.textContent=value==='prerelease'?translate('betaWarning'):translate('masterWarning'); } function fillPlan(){ const plan=currentPlan; document.getElementById('planVersion').textContent=plan.version; document.getElementById('planSize').textContent=translate(plan.downloadBytes?'downloadExact':'downloadEstimated').replace('{size}',megabytes(plan.downloadBytes||plan.downloadLimit)); document.getElementById('planUnpacked').textContent=translate('downloadExact').replace('{size}',megabytes(plan.unpackedBytes)); document.getElementById('planTarget').textContent=plan.target; document.getElementById('planChanges').textContent=plan.changes||translate('noChanges'); document.getElementById('planVerification').textContent=translate(plan.digest?'verificationDigest':'verificationCommit'); document.getElementById('planManualWarning').hidden=!plan.manual; setTextKey(document.getElementById('installerTitle'),plan.repair?'repairTitle':'title'); } async function reviewDownload(event){ event.preventDefault(); if(isBusy||window.installerFatal||window.installerAccepted){ return; } const custom=document.getElementById('customPath').checked; startLoading(translate('fetching')); try{ const result=await request('plan',{branch:document.getElementById('branch').value,customPath:custom?'1':'0',target:document.getElementById('target').value}); currentPlan=result.plan; finishLoadingAlert(); fillPlan(); selectionForm.hidden=true; reviewPanel.hidden=false; document.getElementById('installerError').hidden=true; document.getElementById('logPanel').hidden=true; document.getElementById('confirmInstallation').checked=false; document.getElementById('confirmButton').disabled=true; document.getElementById('confirmInstallation').focus(); }catch(error){ displayError(error); } } function updateProgress(event){ if(event.status==='error'||event.ok===false){ clearTimeout(pollTimer); displayError({...event,blocked:true}); return; } const stages=['downloading','verifying','extracting','placing','finalizing','retrying','complete','preparing']; if(!stages.includes(event.stage)){ return; } if(document.getElementById('installerErrorMessage').dataset.i18n==='streamError'){ document.getElementById('installerError').hidden=true; if(!alertOverlay.hidden){ closeFLAlert(); } } progressPanel.hidden=false; document.getElementById('progressSpinner').hidden=false; document.getElementById('installerSubtitle').hidden=true; reviewPanel.hidden=true; selectionForm.hidden=true; installerForm.hidden=true; currentPercent=Math.max(currentPercent,Math.min(100,Math.max(0,Number(event.percent)||0))); const progress=document.getElementById('installerProgress'); progress.style.setProperty('--progress',currentPercent+'%'); progress.setAttribute('aria-valuenow',String(currentPercent)); document.getElementById('progress-bar-text').textContent=currentPercent+'%'; currentStage=event.stage==='preparing'?'fetching':event.stage; setTextKey(document.getElementById('progressStage'),currentStage); if(Number.isFinite(event.bytes)){ document.getElementById('downloadBytes').textContent=megabytes(event.bytes)+(event.total?' / '+megabytes(event.total):'')+' MB'; } document.querySelectorAll('.installer-stages li').forEach(item=>{ if(item.dataset.stage===event.stage){ item.setAttribute('aria-current','step'); } else{ item.removeAttribute('aria-current'); } }); if(event.stage==='complete'){ clearTimeout(pollTimer); document.getElementById('installerError').hidden=true; document.getElementById('logPanel').hidden=true; window.installerAccepted=false; window.installerRunning=false; languageSelect.disabled=false; document.getElementById('notCancelable').hidden=true; document.getElementById('progressSpinner').hidden=true; setTextKey(document.getElementById('progressStage'),event.manual?'completeManual':'complete'); currentStage=event.manual?'completeManual':'complete'; const target=new URL(event.url,location.href); if(target.origin===location.origin){ document.getElementById('openBrowser').href=target.href; document.getElementById('openBrowser').hidden=false; } } } async function recoverProgress(){ if(!window.installerAccepted){ return; } if(pollCount>=300){ displayError({messageKey:'streamError',code:'OGDW-PROGRESS-TIMEOUT',blocked:true}); return; } pollCount++; try{ const result=await request('status'); if(result.job){ updateProgress(result.job); } if(result.job&&['complete','error'].includes(result.job.status)){ return; } }catch(error){ if(error.messageKey==='sessionError'){ displayError(error); return; } } pollTimer=setTimeout(recoverProgress,2000); } async function acceptInstallation(){ if(!currentPlan||window.installerAccepted||window.installerFatal||!document.getElementById('confirmInstallation').checked){ return; } window.installerAccepted=true; window.installerRunning=true; languageSelect.disabled=true; document.querySelectorAll('#selectionForm input,#selectionForm select,#selectionForm button,#reviewPanel input,#reviewPanel button').forEach(element=>{ element.disabled=true; }); updateProgress({stage:'preparing',percent:0}); try{ const body=new URLSearchParams({action:'start',api:'1',csrf:installerState.csrf,lang:languageSelect.value,plan:currentPlan.id,confirm:'1'}); const response=await fetch(installerEndpoint,{method:'POST',body,credentials:'same-origin'}); if(!response.ok){ displayError(await response.json()); return; } let completed=false; function consume(line){ if(!line.trim()){ return; } const event=JSON.parse(line); updateProgress(event); if(event.status==='complete'||event.status==='error'){ completed=true; } } if(response.body&&response.body.getReader){ const reader=response.body.getReader(),decoder=new TextDecoder(); let buffer=''; while(true){ const result=await reader.read(); buffer+=decoder.decode(result.value||new Uint8Array(),{stream:!result.done}); if(buffer.length>131072){ throw new Error('Invalid progress stream'); } const lines=buffer.split('\n'); buffer=lines.pop(); lines.forEach(consume); if(result.done){ if(buffer.trim()){ consume(buffer); } break; } } }else{ (await response.text()).split('\n').forEach(consume); } if(!completed){ throw new Error('Incomplete progress stream'); } }catch(failure){ displayError({messageKey:'streamError',code:'OGDW-PROGRESS-CONNECTION',blocked:true}); recoverProgress(); } } languageSelect.addEventListener('change',updateLanguage); passwordToggle.addEventListener('click',()=>{ const isVisible=passwordInput.type==='password'; passwordInput.type=isVisible?'text':'password'; passwordToggle.setAttribute('aria-pressed',String(isVisible)); passwordToggle.textContent=translate(isVisible?'hidePassword':'showPassword'); }); document.getElementById('gdclose-fancy-btn').addEventListener('click',closeFLAlert); alertOverlay.addEventListener('click',event=>{ if(event.target===alertOverlay){ closeFLAlert(); } }); document.addEventListener('keydown',event=>{ if(!alertOverlay.hidden){ if(event.key==='Escape'){ closeFLAlert(); } if(event.key==='Tab'){ const controls=alertOverlay.querySelectorAll('a,button'),firstControl=controls[0],lastControl=controls[controls.length-1]; if(event.shiftKey&&document.activeElement===firstControl){ event.preventDefault(); lastControl.focus(); } else if(!event.shiftKey&&document.activeElement===lastControl){ event.preventDefault(); firstControl.focus(); } } } }); document.addEventListener('initLoadingAlert',()=>{ startLoading(translate('fetching')); }); document.addEventListener('finishLoadingAlert',finishLoadingAlert); installerForm.addEventListener('submit',submitForm); installerForm.addEventListener('invalid',event=>{ event.target.setCustomValidity(translate('requiredError')); },true); installerForm.addEventListener('input',event=>{ if(typeof event.target.setCustomValidity==='function'){ event.target.setCustomValidity(''); } }); selectionForm.addEventListener('submit',reviewDownload); document.getElementById('branch').addEventListener('change',updateBranchWarning); document.getElementById('customPath').addEventListener('change',event=>{ document.getElementById('customPathFields').hidden=!event.target.checked; }); document.getElementById('confirmInstallation').addEventListener('change',event=>{ document.getElementById('confirmButton').disabled=!event.target.checked; }); document.getElementById('backSelection').addEventListener('click',()=>{ if(!window.installerAccepted){ reviewPanel.hidden=true; selectionForm.hidden=false; currentPlan=null; } }); document.getElementById('confirmButton').addEventListener('click',acceptInstallation); document.getElementById('copyLog').addEventListener('click',async()=>{ const field=document.getElementById('supportLog'),status=document.getElementById('copyLogStatus'); try{ await navigator.clipboard.writeText(field.value); setTextKey(status,'copiedLog'); }catch(failure){ field.focus(); field.select(); setTextKey(status,'copyFallback'); } }); window.addEventListener('beforeunload',event=>{ if(window.installerRunning){ event.preventDefault(); event.returnValue=''; } }); window.addEventListener('pageshow',finishLoadingAlert); if(currentAlert){ renderInstallerAlert(); } if(installerState.plan){ currentPlan=installerState.plan; fillPlan(); selectionForm.hidden=true; reviewPanel.hidden=false; } if(installerState.job){ languageSelect.disabled=true; updateProgress(installerState.job); if(installerState.job.status==='running'){ recoverProgress(); } } window.installerInitialized=true;</script>
</body>
</html>
<?php
}

runInstaller($translations, $language);
