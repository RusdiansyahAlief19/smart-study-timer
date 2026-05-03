<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight tracking-wide">
            Discover Your Best Study Time
        </h2>
    </x-slot>

    <style>
        :root {
            --col-bg: #0d0f14;
            --col-surface: #151820;
            --col-border: #1e2330;
            --col-muted: #3a3f52;
            --col-text: #e4e8f5;
            --col-subtle: #6b7394;
            --accent: #74a0ff;
            --accent-dim: rgba(74, 158, 255, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--col-text);
            background: var(--col-bg);
        }

        .onboarding-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        .onboarding-card {
            background: var(--col-surface);
            border: 1px solid var(--col-border);
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--col-muted);
            transition: all 0.3s ease;
        }

        .step-dot.active {
            background: var(--accent);
            width: 24px;
            border-radius: 4px;
        }

        .step-dot.completed {
            background: var(--accent);
        }

        .question-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--col-text);
        }

        .question-subtitle {
            font-size: 1rem;
            color: var(--col-subtle);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.75rem;
            color: var(--col-text);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: var(--col-bg);
            border: 1px solid var(--col-border);
            border-radius: 8px;
            color: var(--col-text);
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
        }

        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .radio-option {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--col-bg);
            border: 1px solid var(--col-border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .radio-option:hover {
            border-color: var(--accent);
        }

        .radio-option input[type="radio"] {
            margin-right: 1rem;
            accent-color: var(--accent);
        }

        .radio-option.selected {
            border-color: var(--accent);
            background: var(--accent-dim);
        }

        .btn-primary {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: #5a8fee;
        }

        .btn-primary:disabled,
        .btn-primary.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .btn-secondary {
            background: transparent;
            color: var(--col-text);
            border: 1px solid var(--col-border);
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }

        .time-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .time-option {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--col-bg);
            border: 1px solid var(--col-border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .time-option:hover {
            border-color: var(--accent);
        }

        .time-option.selected {
            border-color: var(--accent);
            background: var(--accent-dim);
        }

        .time-option input[type="radio"] {
            margin-right: 1rem;
            accent-color: var(--accent);
        }

        .time-label {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .time-description {
            font-size: 0.875rem;
            color: var(--col-subtle);
        }

        .study-sessions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            max-height: 400px;
            overflow-y: auto;
            padding: 0.5rem;
        }

        .session-option {
            display: flex;
            padding: 1rem;
            background: var(--col-bg);
            border: 1px solid var(--col-border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .session-option:hover {
            border-color: var(--accent);
        }

        .session-option.selected {
            border-color: var(--accent);
            background: var(--accent-dim);
        }

        .session-option input[type="radio"] {
            margin-right: 1rem;
            accent-color: var(--accent);
        }

        .session-content {
            flex: 1;
        }

        .session-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .session-name {
            font-weight: 600;
            color: var(--col-text);
        }

        .session-time {
            font-size: 0.875rem;
            color: var(--accent);
            font-weight: 500;
        }

        .session-description {
            font-size: 0.875rem;
            color: var(--col-subtle);
            margin-bottom: 0.5rem;
        }

        .session-intensity {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
            font-weight: 500;
        }

        .session-intensity[data-intensity="high"] {
            background: rgba(74, 158, 255, 0.2);
            color: var(--accent);
        }

        .session-intensity[data-intensity="medium"] {
            background: rgba(74, 158, 255, 0.1);
            color: var(--accent);
        }

        .session-intensity[data-intensity="low"] {
            background: rgba(255, 255, 255, 0.1);
            color: var(--col-subtle);
        }

        .research-note {
            background: var(--accent-dim);
            border: 1px solid var(--accent);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            color: var(--col-text);
        }

        .research-note strong {
            color: var(--accent);
        }
    </style>

    <div class="onboarding-container" x-data="chronotypeOnboarding()">
        <div class="onboarding-card">
            <!-- Step Indicator -->
            <div class="step-indicator">
                <template x-for="i in 3" :key="i">
                    <div 
                        class="step-dot"
                        :class="{
                            'active': currentStep === i,
                            'completed': currentStep > i
                        }"
                    ></div>
                </template>
            </div>

            <!-- Step 1: Wake Up Time -->
            <div x-show="currentStep === 1">
                <h3 class="question-title">What time do you usually wake up?</h3>
                <p class="question-subtitle">This helps us understand your natural sleep-wake cycle</p>
                
                <div class="form-group">
                    <label class="form-label">Select your typical wake up time</label>
                    <div class="time-options">
                        <template x-for="time in wakeUpTimes" :key="time.value">
                            <label class="time-option" :class="{'selected': formData.wake_up_time === time.value}">
                                <input type="radio" name="wake_up_time" :value="time.value" x-model="formData.wake_up_time" @change="validateStep">
                                <div>
                                    <div class="time-label" x-text="time.label"></div>
                                    <div class="time-description" x-text="time.description"></div>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Step 2: Productivity Peak -->
            <div x-show="currentStep === 2">
                <h3 class="question-title">When are you most productive?</h3>
                <p class="question-subtitle">Choose the study session when you feel most focused and energized</p>
                
                <div class="form-group">
                    <div class="study-sessions-grid">
                        <template x-for="session in studySessions" :key="session.value">
                            <label class="session-option" :class="{'selected': formData.productivity_peak === session.value}">
                                <input type="radio" name="productivity_peak" :value="session.value" x-model="formData.productivity_peak" @change="validateStep">
                                <div class="session-content">
                                    <div class="session-header">
                                        <span class="session-name" x-text="session.name"></span>
                                        <span class="session-time" x-text="session.time"></span>
                                    </div>
                                    <div class="session-description" x-text="session.description"></div>
                                    <div class="session-intensity" x-text="session.intensity"></div>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Step 3: Age -->
            <div x-show="currentStep === 3">
                <h3 class="question-title">What's your age?</h3>
                <p class="question-subtitle">Age affects our natural sleep patterns and optimal study times</p>
                
                <div class="research-note">
                    <strong>Research Insight:</strong> Studies show that people aged 18-22 naturally perform better starting study sessions after 11:00 AM due to biological sleep pattern shifts.
                </div>
                
                <div class="form-group">
                    <label class="form-label">Age</label>
                    <input 
                        type="number" 
                        x-model="formData.age"
                        class="form-input"
                        min="13"
                        max="100"
                        placeholder="Enter your age"
                        @input="validateStep"
                    >
                </div>
            </div>

            <!-- Navigation -->
            <div class="navigation-buttons">
                <button 
                    x-show="currentStep > 1"
                    @click="previousStep"
                    class="btn-secondary"
                >
                    Previous
                </button>
                
                <button 
                    @click="nextStep"
                    class="btn-primary"
                    :disabled="!isStepValid"
                    :class="{ 'disabled': !isStepValid }"
                    x-text="currentStep === 3 ? 'Complete' : 'Next'"
                >
                </button>
            </div>
        </div>
    </div>

    <script>
    function chronotypeOnboarding() {
        return {
            currentStep: 1,
            isStepValid: false,
            formData: {
                wake_up_time: '',
                productivity_peak: '',
                age: ''
            },
            wakeUpTimes: [
                { value: '05:00', label: '5:00 AM', description: 'Aurora Scholar - Early bird' },
                { value: '06:00', label: '6:00 AM', description: 'Golden Hour Learner - Natural wake' },
                { value: '07:00', label: '7:00 AM', description: 'Golden Hour Learner - Cortisol peak' },
                { value: '08:00', label: '8:00 AM', description: 'Sharp Mind - Peak focus time' },
                { value: '09:00', label: '9:00 AM', description: 'Sharp Mind - Analytical thinking' },
                { value: '10:00', label: '10:00 AM', description: 'Flow Rider - Deep work start' },
                { value: '11:00', label: '11:00 AM', description: 'Flow Rider - Optimal momentum' },
                { value: '12:00', label: '12:00 PM', description: 'Brave Soul - Post-lunch dip' },
                { value: '13:00', label: '1:00 PM', description: 'Brave Soul - Energy low' },
                { value: '14:00', label: '2:00 PM', description: 'Second Wave - Energy rising' },
                { value: '15:00', label: '3:00 PM', description: 'Second Wave - Review time' },
                { value: '16:00', label: '4:00 PM', description: 'Golden Dusk - Memory peak' },
                { value: '17:00', label: '5:00 PM', description: 'Golden Dusk - Memorization' },
                { value: '18:00', label: '6:00 PM', description: 'Night Scholar - Evening focus' },
                { value: '19:00', label: '7:00 PM', description: 'Night Scholar - Deep reading' },
                { value: '20:00', label: '8:00 PM', description: 'Night Scholar - Quiet time' },
                { value: '21:00', label: '9:00 PM', description: 'Midnight Thinker - Creative peak' },
                { value: '22:00', label: '10:00 PM', description: 'Midnight Thinker - Brainstorming' },
                { value: '23:00', label: '11:00 PM', description: 'Lone Warrior - High risk' }
            ],
            studySessions: [
                { value: 'aurora', name: 'Aurora Scholar', time: '5:00 AM - 7:00 AM', description: 'Meditative learning, minimal distractions', intensity: 'Low' },
                { value: 'golden_hour', name: 'Golden Hour Learner', time: '7:00 AM - 9:00 AM', description: 'Natural cortisol peak, optimal focus', intensity: 'High' },
                { value: 'sharp_mind', name: 'Sharp Mind', time: '9:00 AM - 11:00 AM', description: 'Peak analytical thinking and problem solving', intensity: 'High' },
                { value: 'flow_rider', name: 'Flow Rider', time: '11:00 AM - 1:00 PM', description: 'Optimal for deep work and momentum', intensity: 'High' },
                { value: 'brave_soul', name: 'Brave Soul', time: '1:00 PM - 3:00 PM', description: 'Requires extra effort, good for active learning', intensity: 'Medium' },
                { value: 'second_wave', name: 'Second Wave', time: '3:00 PM - 5:00 PM', description: 'Energy rising, great for review and consolidation', intensity: 'Medium' },
                { value: 'golden_dusk', name: 'Golden Dusk', time: '5:00 PM - 7:00 PM', description: 'Enhanced memory and memorization', intensity: 'Medium' },
                { value: 'night_scholar', name: 'Night Scholar', time: '7:00 PM - 9:00 PM', description: 'Quiet environment, ideal for deep reading', intensity: 'High' },
                { value: 'midnight_thinker', name: 'Midnight Thinker', time: '9:00 PM - 11:00 PM', description: 'Creativity and associative thinking peak', intensity: 'Medium' },
                { value: 'lone_warrior', name: 'Lone Warrior', time: '11:00 PM - 1:00 AM', description: 'High risk, poor memory retention', intensity: 'Low' },
                { value: 'late_warrior', name: 'Lone Warrior', time: '1:00 AM - 3:00 AM', description: 'Very high risk, avoid if possible', intensity: 'Low' }
            ],

            init() {
                this.validateStep();
            },

            validateStep() {
                switch(this.currentStep) {
                    case 1:
                        this.isStepValid = this.formData.wake_up_time !== '';
                        console.log('Step 1 validation:', { wake_up_time: this.formData.wake_up_time, valid: this.isStepValid });
                        break;
                    case 2:
                        this.isStepValid = this.formData.productivity_peak !== '';
                        console.log('Step 2 validation:', { productivity_peak: this.formData.productivity_peak, valid: this.isStepValid });
                        break;
                    case 3:
                        const age = parseInt(this.formData.age);
                        this.isStepValid = this.formData.age !== '' && !isNaN(age) && age >= 13 && age <= 100;
                        console.log('Step 3 validation:', { age: this.formData.age, parsed: age, valid: this.isStepValid });
                        break;
                }
            },

            nextStep() {
                if (!this.isStepValid) return;

                if (this.currentStep === 3) {
                    this.submitChronotype();
                } else {
                    this.currentStep++;
                    this.validateStep();
                }
            },

            previousStep() {
                if (this.currentStep > 1) {
                    this.currentStep--;
                    this.validateStep();
                }
            },

            async submitChronotype() {
                console.log('Submitting chronotype data:', this.formData);
                
                // Frontend validation before sending
                if (!this.formData.wake_up_time) {
                    alert('Please select your wake up time.');
                    return;
                }
                
                if (!this.formData.productivity_peak) {
                    alert('Please select your most productive time.');
                    return;
                }
                
                if (!this.formData.age || this.formData.age < 13 || this.formData.age > 100) {
                    alert('Please enter a valid age between 13 and 100.');
                    return;
                }
                
                try {
                    const response = await fetch('/chronotype', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(this.formData)
                    });

                    console.log('Response status:', response.status);
                    
                    if (response.ok) {
                        const result = await response.json();
                        console.log('Submission successful:', result);
                        window.location.href = '/chronotype/celebration';
                    } else {
                        const errorData = await response.json();
                        console.error('Submission failed:', response.status, errorData);
                        
                        if (response.status === 422) {
                            // Validation errors
                            let errorMessage = 'Please fix the following errors:\n';
                            for (const [field, errors] of Object.entries(errorData.messages || {})) {
                                errorMessage += `${field}: ${errors.join(', ')}\n`;
                            }
                            alert(errorMessage);
                        } else {
                            alert(errorData.error || 'There was an error submitting your chronotype. Please try again.');
                        }
                    }
                } catch (error) {
                    console.error('Error submitting chronotype:', error);
                    alert('Network error. Please check your connection and try again.');
                }
            }
        }
    }
    </script>
</x-app-layout>
