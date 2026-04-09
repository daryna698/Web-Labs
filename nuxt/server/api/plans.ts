export default defineEventHandler(() => {
  return [
    {
      title: 'Starter', type: 'Annual', price: '$83.25', priceMonthly: '$99.00', originalYearly: '$1,188', billedYearly: '$999', savings: '$189 in savings',
      features: [
        { main: 'Primary user only', sub: '(extra team members for $35/month)' },
        { main: 'Save unlimited properties' },
        { highlight: '10,000', main: 'exports', sub: '(additional exports at $0.02 each)' },
        { highlight: '500', main: 'free skip traces', sub: '(additional skip tracing at $0.08 each)' },
        { main: 'Imports $0.01' }
      ]
    },
    {
      title: 'Team', type: 'Annual', price: '$207.50', priceMonthly: '$249.00', originalYearly: '$2,988', billedYearly: '$2,490', savings: '$498 in savings', isPopular: true,
      features: [
        { main: 'Primary user + 2 free team members', sub: '(extra team members for $25/month)' },
        { main: 'Save unlimited properties' },
        { highlight: '50,000', main: 'exports', sub: '(additional exports at $0.01 each)' },
        { highlight: '1,000', main: 'free skip traces', sub: '(additional skip tracing at $0.08 each)' },
        { main: 'Imports $0.01' },
        { highlight: 'FREE', main: 'daily product trainings and support' },
        { main: 'Full suite of next-gen investing tools' },
        { main: 'Industry first AI powered comp tool' },
        { main: 'Includes dedicated support agent' }
      ]
    },
    {
      title: 'Business', type: 'Annual', price: '$457.50', priceMonthly: '$549.00', originalYearly: '$6,588', billedYearly: '$5,490', savings: '$1,098 in savings',
      features: [
        { main: 'Primary user + 6 free team members', sub: '(extra team members for $20/month)' },
        { main: 'Save unlimited properties' },
        { highlight: '100,000', main: 'exports', sub: '(additional exports at $0.01 each)' },
        { highlight: '2,000', main: 'free skip traces', sub: '(additional skip tracing at $0.08 each)' },
        { main: 'Imports $0.01' },
        { highlight: 'FREE', main: 'daily product trainings and support' },
        { main: 'Full suite of next-gen investing tools' },
        { main: 'Industry first AI powered comp tool' },
        { main: 'Includes dedicated support agent' }
      ]
    }
  ]
})
