import { startStimulusApp } from '@symfony/stimulus-bridge';
import { locale } from '@amorebietakoudala/stimulus-controller-bundle/src/locale_controller';
import { table } from '@amorebietakoudala/stimulus-controller-bundle/src/table_controller';
import { datetimepicker } from '@amorebietakoudala/stimulus-controller-bundle/src/datetimepicker_controller';
import { select2 } from '@amorebietakoudala/stimulus-controller-bundle/src/select2_controller';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
app.register('locale', locale );
app.register('table', table );
app.register('datetimepicker', datetimepicker );
app.register('select2', select2 );

