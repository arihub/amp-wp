<?php

namespace PHPSTORM_META {

	override( \AmpProject\AmpWP\Services::get(), map( [
		'admin.analytics_menu'             => \AmpProject\AmpWP\Admin\AnalyticsOptionsSubmenu::class,
		'admin.google_fonts'               => \AmpProject\AmpWP\Admin\GoogleFonts::class,
		'admin.onboarding_menu'            => \AmpProject\AmpWP\Admin\OnboardingWizardSubmenu::class,
		'admin.onboarding_wizard'          => \AmpProject\AmpWP\Admin\OnboardingWizardSubmenuPage::class,
		'admin.options_menu'               => \AmpProject\AmpWP\Admin\OptionsMenu::class,
		'admin.polyfills'                  => \AmpProject\AmpWP\Admin\Polyfills::class,
		'amp_slug_customization_watcher'   => \AmpProject\AmpWP\AmpSlugCustomizationWatcher::class,
		'css_transient_cache.ajax_handler' => \AmpProject\AmpWP\Admin\ReenableCssTransientCachingAjaxAction::class,
		'css_transient_cache.monitor'      => \AmpProject\AmpWP\BackgroundTask\MonitorCssTransientCaching::class,
		'dev_tools.user_access'            => \AmpProject\AmpWP\Admin\DevToolsUserAccess::class,
		'error_page'                       => \AmpProject\AmpWP\ErrorPage::class,
		'extra_theme_and_plugin_headers'   => \AmpProject\AmpWP\ExtraThemeAndPluginHeaders::class,
		'mobile_redirection'               => \AmpProject\AmpWP\MobileRedirection::class,
		'obsolete_block_attribute_remover' => \AmpProject\AmpWP\ObsoleteBlockAttributeRemover::class,
		'plugin_activation_notice'         => \AmpProject\AmpWP\Admin\PluginActivationNotice::class,
		'plugin_registry'                  => \AmpProject\AmpWP\PluginRegistry::class,
		'plugin_suppression'               => \AmpProject\AmpWP\PluginSuppression::class,
		'reader_theme_loader'              => \AmpProject\AmpWP\ReaderThemeLoader::class,
		'rest.options_controller'          => \AmpProject\AmpWP\OptionsRESTController::class,
		'server_timing'                    => \AmpProject\AmpWP\Instrumentation\ServerTiming::class,
		'site_health_integration'          => \AmpProject\AmpWP\Admin\SiteHealth::class,
		'validated_url_stylesheet_gc'      => \AmpProject\AmpWP\BackgroundTask\ValidatedUrlStylesheetDataGarbageCollection::class,
	] ) );
}
