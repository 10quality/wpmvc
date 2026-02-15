import clsx from 'clsx';
import Heading from '@theme/Heading';
import styles from './styles.module.css';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
  faLayerGroup,
  faSyringe,
  faCode,
  faPersonRunning,
  faTruckRampBox,
} from '@fortawesome/free-solid-svg-icons';
import {
  faWordpress,
  faGulp,
  faGithub,
} from '@fortawesome/free-brands-svg-icons';

const FeatureList = [
  {
    title: 'MVC',
    icon: faLayerGroup,
    description: (
      <>
        Implements the <strong>model-view-controller</strong> design pattern.
      </>
    ),
  },
  {
    title: 'Dependency Injection',
    icon: faSyringe,
    description: (
      <>
        Implements the dependency injection design pattern using Composer and Npm.
      </>
    ),
  },
  {
    title: 'Scaffolding',
    icon: faCode,
    description: (
      <>
        Scaffolding via Ayuco command-line interpreter.
      </>
    ),
  },
  {
    title: 'WordPress Integration',
    icon: faWordpress,
    description: (
      <>
        Complete WordPress integration; supports hooks, widgets and shortcodes.
      </>
    ),
  },
  {
    title: 'Gulp',
    icon: faGulp,
    description: (
      <>
        Gulp (tasker) integration for compilation, compression, and deployment.
      </>
    ),
  },
  {
    title: 'Performance',
    icon: faPersonRunning,
    description: (
      <>
        Optimized for enterprise level performance. Has internal buffering and takes in consideration memory allocation.
      </>
    ),
  },
  {
    title: 'Extendable',
    icon: faTruckRampBox,
    description: (
      <>
        The functionality and features of a project can be easily extended through community-developed add-ons.
      </>
    ),
  },
  {
    title: 'Open Sourced',
    icon: faGithub,
    description: (
      <>
        FREE, powerful, public code visibility and frequently updated.
      </>
    ),
  },
];

function Feature({icon, title, description}) {
  return (
    <div className={clsx('col col--3')}>
      <div className="text--center margin-bottom--sm">
        <FontAwesomeIcon icon={icon} size="2xl"/>
      </div>
      <div className="text--center padding-horiz--md">
        <Heading as="h3">{title}</Heading>
        <p>{description}</p>
      </div>
    </div>
  );
}

export default function HomepageFeatures(props) {
    const Style = {
        '--bg-img': `url(${props.bgUrl})`,
    };
  return (
    <section className={styles.features}>
      <div className={styles.underlay} style={Style}></div>
      <div className="container">
        <div className="row">
          {FeatureList.map((props, idx) => (
            <Feature key={idx} {...props} />
          ))}
        </div>
      </div>
    </section>
  );
}
