import { startStimulusApp } from '@symfony/stimulus-bridge';
import Autocomplete from '@symfony/ux-autocomplete';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

app.register('autocomplete', Autocomplete);
